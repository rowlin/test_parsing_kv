<template>
    <div>
        <table class="table">
            <thead id="panel">
            <tr>
                <th colspan="4" class="left pointer" >
                <span @click="upgrade()" class="">Load new estates from kv</span>
                </th>
                <th colspan="2" class="center pointer" >
                    <span>{{message}}</span><span @click="">Clear request</span>
                </th>
                <th >
                    <div style="display: flex" v-if="$root.estates">
                        <div class="m10" v-if="$root.estates.current_page > 1">
                            <a @click="$root.filter.page-- ; updateFilter()"  ><</a>
                        </div>
                            <select @change="updateFilter" v-model="$root.filter.perPage" >
                                <option v-for="(per , index) in this.perPage" :id="index" :value="per" :selected="per === $root.estates.per_page" >
                                    {{ per }}
                                </option>
                            </select>
                        <div class="m10" v-if="$root.estates.current_page < $root.estates.last_page">
                            <a @click="$root.filter.page++ ; updateFilter()">></a>
                        </div>
                    </div>
                    <div>
                        {{ $root.estates.current_page }}/{{ $root.estates.last_page }}

                    </div>
                </th>
           </tr>
            <tr>
                <th style="width: 100px;">
                </th>
                <th>
                    <label for="deal_type">Deal</label>
                    <select name="deal_type" @change="updateFilter" v-model="$root.filter.deal_type" id="deal_type">
                        <option v-for="d in JSON.parse(this.dealTypes)" :key="d.id" :value="d.id">{{ d.name }}</option>
                    </select>
                </th>
                <th>
                    <label for="address">Address</label>
                    <input name="text" id="address" @change="updateFilter" v-model="$root.filter.address">
                </th>
                <th>
                     <label for="float">Float</label>
                      <input type="number" size="2" id="float" @chang="updateFilter" v-model="$root.filter.float" />
                </th>
                <th>
                    <label for="float">Tot. Float</label>
                    <input type="number" size="2" id="float_total" @change="updateFilter" v-model="$root.filter.float_total"/>
                </th>
                <th>
                    <label for="area">Area</label>
                    <input type="number" size="2" id="area" @change="updateFilter" v-model="$root.filter.area_total"/>
                </th>
                <th>
                    <label for="area">Year</label>
                    <input type="number" size="4" id="year" @change="updateFilter" v-model="$root.filter.year"/>
                </th>
                <th>
                    <label for="price">Price</label>
                    <input type="number" id="price"  size="6" @change="updateFilter" v-model="$root.filter.price" />
                </th>
                <th>
                    <label for="price_per_m2">Price/m2</label>
                    <input type="number" id="price_per_m2"  size="6" @change="updateFilter" v-model="$root.filter.price_per_m2" />
                </th>
            </tr>
            </thead>
            <tbody v-if="$root.estates.data">
            <slot v-for="(estate , index)  in $root.estates.data" >
                <tr :key="index" >
                    <td colspan="9" v-html="estate.description_full"></td>
                </tr>
            </slot>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "TableComponents.vue",
    props : ['dealTypes'],
    data() { return {
            perPage: [10,15 , 20, 30, 40, 50],
            message :''
        }
    },
    mounted() {
        this.updateFilter();
    },
    methods:{
        updateFilter() {
            var queryString = Object.keys(this.$root.filter).map((key) => {
                if(this.$root.filter[key] !== null)
                    return key + '=' + encodeURIComponent(this.$root.filter[key]) + '&'
            }).join("");
            fetch('/api/estate?' + queryString).then(function(response) {
                return response.json();
            })
                .then((data) => {
                    this.$root.estates = data;
                })
                .catch((data) => { console.log(data) } );
        },
        clear(){
          this.$root.filter = {
              'deal_type': 1,
              'float': null,
              'address': null,
              'float_total': null,
              'total_area': null,
              'year': null,
              'price': null,
              'page': 1,
              'perSize': 10,
          };
            this.updateFilter()
        },
        upgrade(){
            fetch('/api/upgrade/ALL').then((response) => {
                return response.json();
            })
            .then((data) => {
                if(data.message){
                    this.message =  data.message;
                    this.updateFilter();
                }else{
                    this.message =  "Oops : something was wrong";
                }
            });
        }
    }
}
</script>

<style scoped lang="scss">
.pointer{
    cursor: pointer;
}

#panel {
    .m10{
        margin: 10px;
        cursor: pointer;
    }
    .left {
        text-align: left;
    }
    .right{
        text-align: right;
    }
    label {
        display: inline-block;
    }
    input , select{
        display: block;
    }
}
</style>
