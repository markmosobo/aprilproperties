<template>
    <TheMaster>
        <div class="card px-2">
       <div class="card-body">
          <!-- General Form Elements -->
          <form @submit.prevent="">
          <fieldset v-if="step == 1">
             <h5 class="card-title text-center">Add Expense</h5>
 
             <div class="row m-auto p-auto justify-content- g-3 needs-validation" novalidate="" autocomplete="off">
                <div class="row  mb-3"></div>
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
                      >Unit*</label
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
                      <label for="inputPassword" class="form-label">Amount Paid*</label>
                      <div class="col-sm-10">
                        <input
                            type="number"
                            placeholder="Amount Paid"
                            id="title"
                            name="title"
                            v-model="form.amount_paid"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Paid To*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Paid To"
                            id="title"
                            name="title"
                            v-model="form.paid_to"
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
                      <label for="inputPassword" class="form-label">Remarks*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="e.g Slashing or Repair Works"
                            id="title"
                            name="title"
                            v-model="form.payment_type"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>


                </div>

             </div>
             <!--  button -->
             <div class="col-lg-12 felx mt-4 row">
                <div class="col-sm-6 col-lg-6">
                    <!-- <button @click.prevent="prev()" class="btn btn-dark">Previous</button> -->
                </div>
                <div class="col-sm-6 col-lg-6 text-end">
                    <button type="submit" @click.prevent="submit()" class="btn btn-sm btn-primary rounded-pill">Submit</button>
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
          user: []
       }   
    },
    methods: {
      async getUnits() {
         try {
           //const propunits = this.units.find(unit => unit.pms_property_id === this.form.pms_property_id);
           this.propunits = this.units.filter(item => item.pms_property_id === this.form.pms_property_id);

           console.log("amoit", this.propunits)
         } catch (error) {
           console.error(error);
         }
       },       
       loadLists() {
          axios.get('api/lists').then((response) => {
          this.units = response.data.lists.units;
          this.properties = response.data.lists.pmsproperties;
 
          });
       },
       submit(){
          axios.post("api/pmsexpenses", this.form)
          .then(function (response) {
             console.log(response);
             // this.step = 1;
             toast.fire(
                'Success!',
                'Expense added!',
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
          this.$router.push('/pmsexpenses')
       }
 
    },
    mounted() {
      this.loadLists()
      this.user = JSON.parse(localStorage.getItem('user'));
      this.form.checked_by = this.user.id
      console.log(this.user.id)      
    }
 
 }
 </script>
    
 
 
