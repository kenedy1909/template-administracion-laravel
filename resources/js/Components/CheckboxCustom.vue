<template>
    <div class="flex items-center mb-4">
        <input @input="(event) => $emit('update:checked', event.target.checked)" type="checkbox" :checked="checked"
            :id="fieldId"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label :for="fieldId" class="ms-2 text-sm font-medium text-gray-900">
            {{ label }} </label>
    </div>
    <!--     <input @input="(event) => $emit('update:checked', event.target.checked)" type="checkbox" :checked="checked"
        :id="fieldId" class="mr-2 hidden" />
    <label :for="fieldId" class="flex flex-row items-center font-bold text-gray-800 cursor-pointer select-none">
        <i class="fa mr-2" :class="{
            'fa-check-square text-blue-600': checked,
            'fa-square text-gray-500': !checked,
        }"></i>
        {{ label }}
    </label> -->
</template>
  
<script>
export default {
    props: {
        label: String,
        fieldId: {
            type: String,
            required: true,
        },
        checked: {
            type: Boolean,
        },
    },
};
</script>
  
<style></style>
  