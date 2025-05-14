<template>
    <div class="facebook-card">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>
<script>
export default {
    name: 'SpinnerLoader',
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
