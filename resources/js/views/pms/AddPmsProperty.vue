<template>
  <TheMaster>
    <div class="card px-2">
       <div class="card-body">
          <!-- General Form Elements -->
          <form @submit.prevent="">
             <h5 class="card-title text-center">Add Property</h5>
 
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
                       <label for="validationCustom04" class="form-label">Name*</label>
                       <div class="col-sm-10">
                          <input type="text" placeholder="Name" id="title" v-model="form.name" name="title" class="form-control"
                             required="" />
                          <div class="invalid-feedback">Please enter title</div>
                       </div>
                    </div>
                    <div class="col-sm-6">
                       <label for="validationCustom04" class="form-label">Number of Units*</label>
                       <div class="col-sm-10">
                          <input type="text" placeholder="Number of Units" v-model="form.units_no" id="location" name="location" class="form-control"
                             required="" />
                          <div class="invalid-feedback">Please enter location!</div>
                       </div>
                    </div>
 
                </div>
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <div class="col-sm-6">
                      <label for="validationCustom04" class="form-label"
                      >Landlord*<p>in case landlord is not listed, click <strong @click="addLandlord">here</strong> to add</p></label
                      >
                      <div class="col-sm-10">
                         <select name="landlord" v-model="form.landlord_id" class="form-select" id="">
                            <option value="0" selected disabled>Select Landlord</option>
                            <option v-for="landlord in landlords" :value="landlord.id"
                            :selected="landlord.id == form.landlord_id" :key="landlord.id">{{ landlord.first_name}} {{ landlord.last_name}}</option>
 
                         </select>
 
                      <div class="invalid-feedback">Please enter category!</div>
                      </div>
                   </div>                
                   <div class="col-sm-6">
                       <label for="validationCustom04" class="form-label">% of Commission*
                        <p>the percentage to be deducted from the total rent collected</p>
                       </label>
                       <div class="col-sm-10">
                          <input type="text" placeholder="Write in decimal e.g 0.05" v-model="form. commission" id="location" name="location" class="form-control"
                             required="" />
                          <div class="invalid-feedback">Please enter location!</div>
                       </div>
                    </div>               
                   </div>
                   <div class="row mb-3"></div>
               
             </div>
             <!--  button -->
             <div class="col-lg-12 felx mt-4 row">
                <div class="col-sm-6 col-lg-6">
                    <!-- <button @click.prevent="prev()" class="btn btn-dark">Previous</button> -->
                </div>
                <div class="col-sm-6 col-lg-6 text-end">
                    <button type="submit" @click.prevent="submit()" class="btn btn-success rounded-pill">Submit</button>
                </div>
            </div>
 
 
          </form>
 
 
          <!-- End General Form Elements -->
       </div>
    </div>
 </TheMaster>
 
    <!--  actual form -->
 </template>
    
 <script>
 import TheMaster from "@/components/dashboard/TheMaster.vue";
 import AddPropertyForm from "@/components/forms/AddPropertyForm.vue";
 import axios from "axios";
 import Swal from 'sweetalert2';
 import Uploader from 'vue-media-upload'
 
 const toast = Swal.mixin({
     toast: true,
     position: 'top-end',
     showConfirmButton: false,
     timer: 3000
 });
 
 window.toast = toast;

 export default {
   components:{
      Uploader,
      TheMaster,
      AddPropertyForm
   },
    data () {
       return {
          user: [],
          form: {         
          created_by: '',
          media: [],
          property_status: '',
          
          },
          message: "",
          successMessage: "",
          loading: false,
          step: 1, 
          landlords: [],
       }   
    },
    methods: {
       addLandlord(){
         this.$router.push('/add-pmslandlord')
       },
       submit(){
          axios.post("api/pmsproperties", this.form)
          .then(function (response) {
             console.log(response);
             let propdata = response.data.property
             console.log("data",propdata.id)             

             toast.fire(
                'Success!',
                'Property added!',
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

          this.$router.push('/pmsproperties');              
       },
        loadLists() {
             axios.get('api/lists').then((response) => {
             this.landlords = response.data.lists.landlords;
    
             });
        },       
 
    },
    mounted() {
       this.loadLists();
       this.user = localStorage.getItem('user');
       this.user = JSON.parse(this.user);
       this.form.created_by = this.user.id;
       this.form.phone_number = this.user.phone
       console.log("user",this.user)

    }
 
 }
 </script>
    
 
 
 <style lang="css" scoped>
 /*Profile Pic Start*/
 .picture-container {
    position: relative;
    cursor: pointer;
    text-align: center;
 }
 .content.ct-wizard-green .picture:hover {
    border-color: #05ae0e;
 }
 
 .content.ct-wizard-blue .picture:hover {
    border-color: #3472f7;
 }
 
 .content.ct-wizard-orange .picture:hover {
    border-color: #ff9500;
 }
 
 .content.ct-wizard-red .picture:hover {
    border-color: #ff3b30;
 }
 
 .picture input[type="file"] {
    cursor: pointer;
    display: block;
    height: 100%;
    left: 0;
    opacity: 0 !important;
    position: absolute;
    top: 0;
    width: 100%;
 }
 
 .picture-src {
    width: 100%;
 
 }</style>