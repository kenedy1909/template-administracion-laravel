<template>
    <!-- Checkbox para seleccionar todos -->
    <div class="mt-3 mb-6 flex items-center">
        <input type="checkbox" id="selectall" v-model="selectAll" @change="selectAllOptions"
            class="text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" />
        <label for="selectall" class="ms-2 font-medium text-gray-700">Seleccionar
            todos</label>
    </div>

    <div class="flex flex-col items-start justify-center w-64 border-2 border-gray-400 p-8 rounded-lg bg-gray-100">
        <check-box v-for="option in options" :checked="value.includes(option.id)" @update:checked="check(option.id, $event)"
            :fieldId="option.name" :label="option.name" :key="option" />
    </div>
</template>
  
<script>
import Checkbox from "./CheckboxCustom.vue";
import { ref } from 'vue';
export default {
    emits: ["update:value"],
    props: {
        value: {
            type: Array,
            required: true,
        },
        options: {
            type: Array,
            required: true,
            validator: (value) => {
                const hasNameKey = value.every((option) =>
                    Object.keys(option).includes("name")
                );
                const hasIdKey = value.every((option) =>
                    Object.keys(option).includes("id")
                );
                return hasNameKey && hasIdKey;
            },
        },
    },
    setup(props, context) {
        // Variable para controlar el estado del checkbox de selección total
        const selectAll = ref(false);

        // Función para seleccionar/deseleccionar todos los elementos
        const selectAllOptions = () => {
            console.log(selectAll.value);
            if (selectAll.value) {
                // Si se selecciona, se agregan todos los IDs al valor
                const allIds = props.options.map(option => option.id);
                context.emit("update:value", allIds);
            } else {
                // Si se deselecciona, se vacía el valor
                context.emit("update:value", []);
            }
        };
        const check = (optionId, checked) => {
            let updatedValue = [...props.value];
            if (checked) {
                updatedValue.push(optionId);
            } else {
                updatedValue.splice(updatedValue.indexOf(optionId), 1);
                // Si al menos un checkbox individual se deselecciona, se deselecciona el de seleccionar todos
                selectAll.value = false;
            }
            context.emit("update:value", updatedValue);
        };

        return {
            selectAll,
            selectAllOptions,
            check,
        };
    },
    components: {
        "check-box": Checkbox,
    },
};
</script>
  