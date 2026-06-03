<script setup>
const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  modelValue: {
    type: [String, Number, File, Object, null],
    default: '',
  },
  error: {
    type: String,
    default: '',
  },
  as: {
    type: String,
    default: 'input',
  },
  type: {
    type: String,
    default: 'text',
  },
  placeholder: {
    type: String,
    default: '',
  },
  rows: {
    type: [String, Number],
    default: 3,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  accept: {
    type: String,
    default: '',
  },
  min: {
    type: [String, Number],
    default: undefined,
  },
  max: {
    type: [String, Number],
    default: undefined,
  },
  step: {
    type: [String, Number],
    default: undefined,
  },
})

const emit = defineEmits(['update:modelValue', 'blur'])

const handleInput = (event) => {
  if (props.type === 'file') {
    emit('update:modelValue', event.target.files?.[0] ?? null)
    return
  }

  emit('update:modelValue', event.target.value)
}
</script>

<template>
  <label class="field">
    <span class="field-label">{{ label }}</span>

    <component
      :is="as"
      :type="as === 'input' ? type : undefined"
      :value="as === 'input' || as === 'textarea' || as === 'select' ? modelValue : undefined"
      :placeholder="placeholder"
      :rows="as === 'textarea' ? rows : undefined"
      :disabled="disabled"
      :accept="type === 'file' ? accept : undefined"
      :min="min"
      :max="max"
      :step="step"
      class="input"
      @blur="$emit('blur')"
      @change="handleInput"
      @input="handleInput"
    >
      <slot />
    </component>

    <p v-if="error" class="error-msg">{{ error }}</p>
  </label>
</template>
