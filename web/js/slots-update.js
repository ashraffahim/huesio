const slots = [];
const tempIds = [];

let newFromTime, newToTime, tempId, code, collisions = [];

const fromTimeInput = $('#from-time');
const toTimeInput = $('#to-time');
const durationInput = $('#duration');
const bufferInput = $('#buffer');
const durationTypeInput = $('#duration-type');
const bufferTypeInput = $('#buffer-type');
const generateSlots = $('#generate-slots');

const updateSlots = $('#update-slots');

fromTimeInput.val('01:00');
toTimeInput.val('09:00');
durationInput.val(1);
bufferInput.val(0.5);

$(document).ready(() => {
    if (currentSlots) {
        currentSlots.forEach((day, dayIndex) => {
            slots[dayIndex] = [];
            day.forEach((slot, slotIndex) => {
                code = '';
                do {
                    for (let i = 0; i < 6; i++) {
                        code += Math.floor(Math.random() * Math.floor(9)).toString();
                    }
                    tempId = Number(code);
                } while (tempIds.includes(tempId));
    
                tempIds.push(tempId);
    
                slots[dayIndex][slotIndex] = getSlotStructure({
                    backId: slot.backId,
                    tempId,
                    row: dayIndex,
                    col: slotIndex,
                    day: dayIndex,
                    from: slot.from,
                    to: slot.to,
                    isOpen: slot.isOpen,
                });
    
                const html = getSlotHTML(slots[dayIndex][slotIndex]);
    
                slots[dayIndex][slotIndex].html = html;
            });
        });

        renderSlots();
    }
});

generateSlots.on('click', function () {
    const fromTime = fromTimeInput.val();
    const toTime = toTimeInput.val();
    const duration = durationTypeInput.val() === 'hr' ? parseInt(durationInput.val() * 60) : parseInt(durationInput.val());
    const buffer = bufferTypeInput.val() === 'hr' ? parseInt(bufferInput.val() * 60) : parseInt(bufferInput.val());

    const fromTimestamp = (new Date()).setHours(...fromTime.split(':'));
    const toTimestamp = (new Date()).setHours(...toTime.split(':'));

    const numberOfSlots = Math.floor((((toTimestamp - fromTimestamp) / 60000) + buffer) / (duration + buffer));

    for (let day = 0; day < 7; day++) {

        slots[day] = [];

        for (let slot = 0; slot < numberOfSlots; slot++) {

            code = '';

            do {

                for (let i = 0; i < 6; i++) {
                    code += Math.floor(Math.random() * Math.floor(9)).toString();
                }

                tempId = Number(code);
            } while (tempIds.includes(tempId));

            tempIds.push(tempId);

            newFromTime = new Date();
            newFromTime.setTime(fromTimestamp + ((slot * (duration + (slot === 0 ? 0 : buffer))) * 60 * 1000));

            newToTime = new Date();
            newToTime.setTime(fromTimestamp + ((((slot + 1) * (duration + buffer)) - buffer) * 60 * 1000));

            slots[day][slot] = getSlotStructure({
                tempId,
                row: day,
                col: slot,
                day,
                from: newFromTime.getHours().toString().padStart(2, '0') + ':' + newFromTime.getMinutes().toString().padStart(2, '0'),
                to: newToTime.getHours().toString().padStart(2, '0') + ':' + newToTime.getMinutes().toString().padStart(2, '0'),
                duration,
                buffer,
            });

            const html = getSlotHTML(slots[day][slot]);

            slots[day][slot].html = html;
        }
    }

    renderSlots();
});

updateSlots.on('click', async function () {
    const csrf = { param: $('meta[name="csrf-param"]').attr('content'), token: $('meta[name="csrf-token"]').attr('content') };

    const headers = new Headers();
    headers.append('X-Requested-With', 'fetch');

    const body = new FormData();
    body.append('slots', JSON.stringify(getSlotsPayload()));
    body.append(csrf.param, csrf.token);

    const response = await fetch(window.location.pathname, {
        headers,
        method: 'POST',
        body,
    });

    if (!response.ok) {
        const { collisions } = await response.json();
        addCollisionError(collisions);
        return;
    };

    const responseData = await response.json();

    slots.forEach((day, dayIndex) => {
        day.forEach((slot, slotIndex) => {
            if (!responseData[slot.tempId]) return;
            slots[dayIndex][slotIndex].backId = responseData[slot.tempId];
        });
    });
});

const renderSlots = () => {
    slots.forEach((day, index) => {

        const dayLine = $(`#slot-${index}`);
        dayLine.html('');

        day.forEach(slot => {
            dayLine
                .append(slot.html);
        });
    });
}

const getSlotHTML = slot => {
    const slotBox = $('<div class="inline-flex flex-row items-center h-24 mx-2 px-3 py-1 border border-gray-200 bg-white rounded-md"></div>');
    const slotCol1 = $('<div class="flex flex-col"></div>');
    const slotCol2 = $('<div class="flex flex-col"></div>');

    const slotFromTimeInputLabel = $('<div class="text-xs text-gray-400">From</div>');
    const slotFromTimeInput = $('<div class="text-xs"></div>');
    const slotToTimeInputLabel = $('<div class="text-xs text-gray-400">To</div>');
    const slotToTimeInput = $('<div class="text-xs"></div>');

    const slotRemove = $('<button class="btn-danger-muted text-xs mt-0"><i class="fa fa-trash"></i></button>')
    const slotEdit = $('<button class="btn-muted text-xs mt-0"><i class="fa fa-pencil"></i></button>')
    const slotStatus = $('<button class="btn-muted text-xs mt-0"></button>')

    slotFromTimeInput.text(slot.from);
    slotToTimeInput.text(slot.to);

    if (slot.isOpen) {
        slotStatus.html('<i class="fa fa-circle-xmark"></i>');
    } else {
        slotStatus.html('<i class="fa fa-circle-check"></i>');
        slotBox.addClass('brightness-50');
    }

    slotRemove.click(() => {
        if (confirm('Removing slot?')) {
            slotBox.remove();
            slots[slot.row].splice(slot.col, 1);
            validateDaySlots(slot.row);
        }
    });

    slotEdit.click(() => {
        const from = prompt('From');

        if (!from) return;
        else if (from.match(/^\d{2}:\d{2}$/) === null) {
            alert('Invalid time format. Use hh:mm format.');
            slotEdit.click();
            return;
        }

        const to = prompt('To');

        if (!to) return;
        else if (to.match(/^\d{2}:\d{2}$/) === null) {
            alert('Invalid time format. Use hh:mm format.');
            slotEdit.click();
            return;
        }

        slots[slot.row][slot.col].from = from;
        slots[slot.row][slot.col].to = to;

        slotFromTimeInput.text(from);
        slotToTimeInput.text(to);

        validateDaySlots(slot.row);
    });

    slotStatus.click(() => {
        slots[slot.row][slot.col].isOpen = !slots[slot.row][slot.col].isOpen;

        if (slots[slot.row][slot.col].isOpen) {
            slotStatus.html('<i class="fa fa-circle-xmark"></i>');
            slotBox.removeClass('brightness-50');
        } else {
            slotStatus.html('<i class="fa fa-circle-check"></i>');
            slotBox.addClass('brightness-50');
        }
    });

    slotCol1
        .append(slotFromTimeInputLabel)
        .append(slotFromTimeInput)
        .append(slotToTimeInputLabel)
        .append(slotToTimeInput);

    slotCol2
        .append(slotRemove)
        .append(slotEdit)
        .append(slotStatus);

    slotBox
        .append(slotCol1)
        .append(slotCol2);

    return slotBox[0];
}

const validateSlots = () => {
    collisions = [];

    slots.forEach((day, dayIndex) => {
        validateDaySlots(dayIndex);
    });
}

const validateDaySlots = dayIndex => {

    clearDaySlotCollisions(dayIndex);

    slots[dayIndex].forEach((slot, slotIndex) => {
        slots[dayIndex].forEach((slot2, slot2Index) => {
            if ((slot.from > slot2.from) && (slot.from < slot2.to)) {

                slots[dayIndex][slotIndex].collisions.push(slot2.tempId);
                $(slots[dayIndex][slotIndex].html).removeClass('border-gray-200').addClass('border-red-600');

                slots[dayIndex][slot2Index].collisions.push(slot.tempId);
                $(slots[dayIndex][slot2Index].html).removeClass('border-gray-200').addClass('border-red-600');

                collisions.push(slot.tempId, slot2.tempId);
            }
        });
    });
}

const addCollisionError = tempIds => {
    slots.forEach(day => {
        day.forEach(slot => {
            if (tempIds.includes(slot.tempId))
                $(slot.html).removeClass('border-gray-200').addClass('border-red-600');
        });
    });
}

const clearDaySlotCollisions = dayIndex => {
    slots[dayIndex].forEach((slot, slotIndex) => {
        $(slot.html).addClass('border-gray-200').removeClass('border-red-600');
        slots[dayIndex][slotIndex].collisions = [];
    })
}

const getSlotStructure = data => {
    return {
        ...{
            backId: null,
            tempId: '',
            row: 0,
            col: 0,
            html: null,
            day: 0,
            from: 0,
            to: 0,
            duration: 0,
            buffer: 0,
            isOpen: true,
            collisions: [],
        },
        ...data
    };
}

const getSlotsPayload = () => {
    const payload = [];

    slots.forEach((day, dayIndex) => {
        payload.push([]);
        day.forEach(slot => {
            payload[dayIndex].push({
                backId: slot.backId,
                tempId: slot.tempId,
                day: slot.day,
                from: slot.from,
                to: slot.to,
                isOpen: slot.isOpen,
            });
        });
    });

    return payload;
}