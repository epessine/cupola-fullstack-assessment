<script setup>
defineProps(['modelValue', 'options']);

defineEmits(['update:modelValue']);
</script>

<template>
    <select
        @input="$emit('update:modelValue', $event.target.value)"
        :value="modelValue"
        class="
            border-0
            focus:ring-0 focus:outline-none
            bg-gray-100
            w-full
            text-gray-400
        "
    >
        <option value="">Todos</option>
        <option v-for="option in options" :key="option.id" :value="option.id">
            {{ option.name }}
        </option>
    </select>
</template>
