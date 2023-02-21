<template>
    <DataTable :value="autos">
        <Column field="vin" header="Vin"></Column>
        <Column field="year" header="Year"></Column>
        <Column field="brand" header="Brand"></Column>
        <Column field="color" header="Color"></Column>
    </DataTable>
</template>

<script>
import AutoService from '../../../../services/AutoService';

export default {
    name: "AdminAutos",
    data: () => ({
        autos: null,

    }),
    autoService: null,
    created() {
        this.autoService = new AutoService();
    },
    async mounted() {
        this.autoService.getAutos().then(data => this.autos = data);
    }


}
</script>

<style scoped>

</style>
