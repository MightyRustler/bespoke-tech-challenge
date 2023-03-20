<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { defineProps, ref, watchEffect } from "vue";
import Card from "@/Components/Card";
import { Inertia } from '@inertiajs/inertia';
import { data } from 'browserslist';
import { exportDefaultSpecifier } from '@babel/types';


const props = defineProps({
    items: Array,
    filters: Object,
})

const search = ref(props.filters.search);

watchEffect( () => {
    Inertia.get('/dashboard', {search: search.value}, {
        preserveState : true,
        replace : true
        }
    );
})
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Company Y Portal
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-2xl">Search</h3>
                        <div class="search-container">
                                <input id="search" name="search_query" v-model="search" type="text" placeholder="Search Items..." />
                                <div class="filter-by">
                                        <label for="info-filter" class="ml-3"> Info
                                            <input type="checkbox" name="info-filter" id="info-filter" value="info" v-model="types" />
                                        </label>
                                        <label for="download-filter" class="ml-3"> Download
                                            <input type="checkbox" name="download-filter" id="download-filter" value="download" v-model="types"/>
                                        </label>
                                        <label for="weblink-filter" class="ml-3"> Weblink
                                            <input type="checkbox" name="weblink-filter" id="weblink-filter" value="weblink" v-model="types" />
                                        </label>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-2xl">Latest Items</h3>

                        <div class="grid gap-4 grid-cols-6 mt-4">
                            <Card v-for="item in getFilteredItems()" :key="item.id" :item="item" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<style>
@import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  font-family: "Montserrat", sans-serif;
}

#search {
  display: block;
  width: 350px;
  margin: 20px auto;
  padding: 10px 45px;
  background: white url("../../images/search-icon.svg") no-repeat 15px center;
  background-size: 15px 15px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px,
    rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
}

[type="checkbox"]
{
    vertical-align:middle;
}

</style>
<script>
export default{
    data(){
        return{
           types:["info", "download", "weblink"],
           items: this.items,
        };
    },
    methods: {
        getFilteredItems(){
            let filteredItems = [];
            this.types.forEach((type) => {
                let foundItems = this.items.filter(e => e.content_type.toLowerCase() === type);
                filteredItems = filteredItems.concat(foundItems);
            })
            return filteredItems;
        }
    }
};
</script>
