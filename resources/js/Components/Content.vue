<script setup>
import { useAppStore } from "@/stores/aplicacion/appStore";
const appStore = useAppStore();
</script>
<template>
    <div class="loading" :class="[appStore.getLoading == true ? 'show' : '']">
        <template v-if="$slots.loading">
            <slot name="loading"></slot>
        </template>
        <template v-else>
            <i class="fa fa-spin fa-spinner fa-4x"></i>
        </template>
    </div>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header" v-if="$slots.header">
            <div class="container-fluid">
                <slot name="header"></slot>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <slot />
            </div>
        </div>
        <!-- /.content -->
    </div>
</template>
