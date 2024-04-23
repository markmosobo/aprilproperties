<template>
    <TheMaster>
        <div class="card px-2">
       <div class="card-body">
          <!-- General Form Elements -->
          <form @submit.prevent="">
          <fieldset v-if="step == 1">
             <h5 class="card-title text-center">Edit tenant</h5>
 
             <div class="row m-auto p-auto justify-content- g-3 needs-validation" novalidate="" autocomplete="off">
                <div class="row  mb-3"></div>
 
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <input
                      type="hidden"
                      id="user_id"
                      name="user_id"
                      value="1"
                      class="form-control"
                   />
                    <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">First Name*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="First Name"
                            id="title"
                            name="title"
                            v-model="form.first_name"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Last Name*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Last Name"
                            id="title"
                            name="title"
                            v-model="form.last_name"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>
 
                </div>
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">ID Number*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="ID Number"
                            id="title"
                            name="title"
                            v-model="form.id_number"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Phone Number*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Phone Number"
                            id="title"
                            name="title"
                            v-model="form.phone_number"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>

                </div>
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <div class="col-sm-6">
                      <label for="validationCustom04" class="form-label"
                      >Property*</label
                      >
                      <div class="col-sm-10">
                         <select @change="getUnits" name="landlord" v-model="form.pms_property_id" class="form-select" id="">
                            <option value="0" selected disabled>Select Property</option>
                            <option v-for="property in properties" :value="property.id"
                            :selected="property.id == form.pms_property_id" :key="property.id">{{ property.name}} </option>
 
                         </select>
 
                      <div class="invalid-feedback">Please enter category!</div>
                      </div>
                   </div>  
                   <div class="col-sm-6">
                      <label for="validationCustom04" class="form-label"
                      >Unit*<p>Current Unit: <strong>{{unitNumber}}</strong></p></label
                      >
                      <div class="col-sm-10">
                         <select :disabled="!form.pms_property_id" name="unit" v-model="form.pms_unit_id" class="form-select" id="">
                            <option value="0" selected disabled>Select Unit</option>
                            <option v-for="unit in propunits" :value="unit.id"
                            :selected="unit.id == form.unit_id" :key="unit.id">{{ unit.unit_number}}</option>
 
                         </select>
 
                      <div class="invalid-feedback">Please enter category!</div>
                      </div>
                   </div>                     
                </div>
             </div>
             <!--  button -->
             <div class="col-lg-12 felx mt-4 row">
                <div class="col-sm-6 col-lg-6">
                    <button @click.prevent="back()" class="btn btn-sm btn-dark rounded-pill">Back</button>
                </div>
                <div class="col-sm-6 col-lg-6 text-end">
                    <button type="submit" @click.prevent="submit()" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill">Submit</button>
                </div>
            </div>
          </fieldset>
 
          </form>
 
 
          <!-- End General Form Elements -->
       </div>
    </div>
    </TheMaster>
    
 
 
    <!--  actual form -->
 </template>
    
 <script>
 import TheMaster from "@/components/dashboard/TheMaster.vue";

 import axios from "axios";
 import Swal from 'sweetalert2';

 
 const toast = Swal.mixin({
     toast: true,
     position: 'top-end',
     showConfirmButton: false,
     timer: 3000
 });
 
 window.toast = toast;
 
 export default {
    components : {
       TheMaster,
    },
    data () {
       return {
          form: {
          role_id: '',
          title: '',
          
          },
          message: "",
          successMessage: "",
          loading: false,
          step: 1, 
          roles: [],
          propunits: [],
          properties: [],
          unitNumber: ''
       }   
    },
    methods: {
        back(){
            this.$router.push('/pmstenants')
        },
        getTenant() {
             axios.get('/api/pmstenant/'+this.$route.params.id).then((response) => {
     
             this.form = response.data.tenant;
             this.unitNumber = response.data.tenant.unit.unit_number;
             console.log("props", response)
    
             });
        }, 
       loadLists() {
          axios.get('/api/lists').then((response) => {
          this.units = response.data.lists.units;
          this.properties = response.data.lists.pmsproperties;
 
          });
       }, 
       getUnits() {
             axios.get('/api/pmsunits/'+this.form.pms_property_id).then((response) => {
     
             this.propunits = response.data.units;
             console.log("props", response)
    
             });         
         // try {
         //   //const propunits = this.units.find(unit => unit.pms_property_id === this.form.pms_property_id);
         //   this.propunits = this.units.filter(item => item.pms_property_id === this.form.pms_property_id && item.status === 0);

         //   console.log("amoit", this.propunits)
         // } catch (error) {
         //   console.error(error);
         // }
       },                    
       submit(){
          axios.put("/api/pmstenant/"+this.$route.params.id, this.form)
          .then(function (response) {
             console.log(response);
             // this.step = 1;
             toast.fire(
                'Success!',
                'Tenant updated!',
                'success'
             )
          })
          .catch(function (error) {
             console.log(error);
             // Swal.fire(
             //    'error!',
             //    // phone_error + id_error + pass_number,
             //    'error'
             // )
          });
          this.$router.push('/pmstenants')
       }
 
    },
    mounted() {
      this.getTenant()
      this.loadLists()
    }
 
 }
 </script>
    
 
 
