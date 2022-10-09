<script setup>
import { ref, onMounted, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SearchInput from '@/Components/SearchInput.vue';
import SearchIcon from '@/Components/SearchIcon.vue';
import SelectInput from '@/Components/SelectInput.vue';
import FilterLabel from '@/Components/FilterLabel.vue';
import CompanyCard from './CompanyCard.vue';
import api from '@/api';

const companies = ref([]);
const states = ref([]);
const cities = ref([]);

const stateId = ref(0);
const cityId = ref(0);
const search = ref('');
const limit = ref(6);

async function loadCompanies() {
    companies.value = await api.companies.index({
        limit: limit.value,
        search: search.value,
        state_id: stateId.value ? stateId.value : null,
        city_id: cityId.value ? cityId.value : null,
    });
}

async function loadStates() {
    states.value = await api.states.index();
}

async function loadCities() {
    cities.value = await api.cities.index({
        state_id: stateId.value ? stateId.value : null,
    });
}

onMounted(() => {
    loadStates();
    loadCities();
    loadCompanies();
});

watch(stateId, () => loadCities());

watch([limit, search, stateId, cityId], () => loadCompanies());

watch([search, stateId, cityId], () => (limit.value = 6));

watch(stateId, () => (cityId.value = 0));
</script>

<template>
    <Head title="Empresas 2022" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div
                            id="filters"
                            class="
                                mt-4
                                mb-12
                                grid grid-cols-1
                                md:grid-cols-3
                                gap-5
                            "
                        >
                            <div class="flex bg-gray-100">
                                <div class="w-full">
                                    <FilterLabel value="Buscar" />
                                    <SearchInput
                                        id="search"
                                        type="text"
                                        class="
                                            block
                                            w-full
                                            placeholder-gray-400
                                        "
                                        v-model="search"
                                        placeholder="Digite o nome"
                                    />
                                </div>
                                <div
                                    class="
                                        flex
                                        items-center
                                        p-2
                                        pr-5
                                        text-gray-400
                                    "
                                >
                                    <SearchIcon class="w-6" />
                                </div>
                            </div>
                            <div class="w-full bg-gray-100">
                                <FilterLabel value="Estado" />
                                <SelectInput
                                    v-model="stateId"
                                    :options="states.data"
                                />
                            </div>
                            <div class="w-full bg-gray-100">
                                <FilterLabel value="Cidade" />
                                <SelectInput
                                    v-model="cityId"
                                    :options="cities.data"
                                />
                            </div>
                        </div>
                        <div
                            id="companies-list"
                            class="grid grid-cols-1 md:grid-cols-2 gap-8"
                        >
                            <CompanyCard
                                v-for="company in companies.data"
                                :key="company.id"
                                :company="company"
                            />
                        </div>
                        <div
                            v-if="
                                companies.meta?.total > companies.data?.length
                            "
                            class="flex items-center justify-center my-8"
                        >
                            <button
                                class="
                                    bg-green-500
                                    rounded
                                    font-semibold
                                    py-3
                                    px-14
                                    text-white
                                "
                                @click="limit = limit + 6"
                            >
                                Carregar Mais
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
