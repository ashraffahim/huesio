function selectClassic(options) {

    if (window.selectClassicInitialized) return;

    window.selectClassicInitialized = true;

    const defaultOptions = {
        nameDataAttr: 'name',
        valueDataAttr: 'value',
        selectSelector: '.select-classic',
        valueSelector: '.select-value',
        optionSelector: '.select-option',
    };

    const finalOptions = {...defaultOptions, ...options};

    $(document).on('click', finalOptions.selectSelector, function() {
        $(this).addClass('open');
    });

    $(document).on('click', finalOptions.optionSelector, function() {
        const item = $(this);
        const select = item.parents(finalOptions.selectSelector);

        const inputName = select.data(finalOptions.nameDataAttr);
        const inputValue = item.data(finalOptions.valueDataAttr);

        select.parents('.has-error').removeClass('has-error');

        item.parents(finalOptions.selectSelector)
        .find(finalOptions.valueSelector)
        .html(
            item.html()
            + '<input type="hidden" name="' + inputName + '" value="' + inputValue + '">'
        );
    });
}