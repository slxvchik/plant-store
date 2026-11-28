<template>
    <section class="table">
        <div class="table__scroll">
            <table class="table__table">
                <slot />
            </table>
        </div>
        <slot name="pagination" />
    </section>
</template>
