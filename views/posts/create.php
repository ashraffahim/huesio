<?php
$this->title = 'Create post';
?>
<div class="h-full flex items-center justify-center">
    <div class="w-3/12 p-3">
        <div class="mb-3">
            <label for="title" class="text-gray-500 text-sm">Title</label>
            <input type="text" name="title" id="title" class="input-classic">
        </div>
        <div class="mb-3">
            <label for="description" class="text-gray-500 text-sm">Description</label>
            <input type="text" name="description" id="description" class="input-classic">
        </div>
        <div class="mb-3">
            <label for="keywords" class="text-gray-500 text-sm">Keywords</label>
            <input type="text" name="keywords" id="keywords" class="input-classic">
        </div>
        <div class="flex flex-1 justify-end">
            <button class="border-0 px-3 py-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded-sm">Create</button>
        </div>
    </div>
</div>
