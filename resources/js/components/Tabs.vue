<template>
    <div class="tabs">
        <div class="tabs__list">
            <Button
                v-for="item in items"
                :key="item.id"
                :class="[
                    'tabs__button',
                    { 'tabs__button--active': activeId === item.id },
                ]"
                :text="item.label"
                style-type="link"
                type="button"
                @click="activeId = item.id"
            />
        </div>
        <div class="tabs__panels">
            <div
                v-for="item in items"
                :key="item.id"
                :class="[
                    'tabs__panel',
                    { 'tabs__panel--open': activeId === item.id },
                ]"
                @transitionend="openId = activeId"
            >
                <div
                    :class="[
                        'tabs__panel-inner',
                        { 'tabs__panel-inner--open': openId === item.id },
                    ]"
                >
                    <div class="tabs__content"><slot :name="item.id" /></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, watch } from 'vue';
import Button from '@/components/Button.vue';

const props = defineProps<{ items: { id: string; label: string }[] }>();
const activeId = ref(props.items[0]?.id || '');
const openId = ref('');
watch(activeId, () => {
    openId.value = '';
});
</script>
