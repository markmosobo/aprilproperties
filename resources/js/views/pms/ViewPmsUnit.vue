<template>
    <TheMaster>
    <div class="container mt-3">
       <div class="row">
         <div class="col-lg-6">             
         <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{form.unit_number}}</h5>
               <p class="card-text">
                  <strong>Type:</strong> {{form.type}} <br>
                  <strong>Rent Deposit:</strong> KES. {{form.deposit}} <br>
                  <strong>Rent:</strong> KES. {{form.monthly_rent}}<br>
                  <strong>Electricity Deposit:</strong> KES. {{form.electricity_deposit}}<br>
                  <strong>Water Deposit:</strong> KES. {{form.water_deposit}}<br>
                  <strong>Garbage Fee:</strong> KES. {{form.garbage_fee}}<br>
                  <strong>Security Fee:</strong> KES. {{form.security_fee}}<br>
                  <strong>Status: </strong>
                  <span v-if="form.status == 0" class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Vacant</span>   
                  <span v-else-if="form.status == 1" class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Occupied</span>
                  <span v-else class="badge bg-light text-dark"><i class="bi bi-star me-1"></i> Closed </span>                  
               </p>
            </div>
          </div>
         </div> 
         <div class="col-lg-6">             
         <div class="card">
            <div class="card-body">
              <h5 class="card-title">Meter Numbers</h5>
               <p class="card-text">
                  <strong>Electricity:</strong> {{form.electricity_meter !== null ? form.electricity_meter : 'N/A'}} <br>
                  <strong>Water:</strong> {{form.water_meter !== null ? form.water_meter : 'N/A'}} <br>
  
               </p>              
            </div>
          </div>
         </div>          
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
       }   
    },
    methods: {
       //ID upload
       onChangePhoto(e) {
         console.log('loadings');
         let file = e.target.files[0];
         console.log(file)
         let reader = new FileReader();
         reader.onloadend = (file) => {
            // console.log('RESULT', reader.result)
            this.form.image = reader.result;
         }
         reader.readAsDataURL(file);
       },
        getUnit() {
             axios.get('/api/pmsunit/'+this.$route.params.id).then((response) => {
     
             this.form = response.data.unit[0];
             console.log("props", this.form)
    
             });
        },       
       submit(){
          axios.put("/api/pmsunit/"+this.$route.params.id, this.form)
          .then(function (response) {
             console.log(response);
             // this.step = 1;
             toast.fire(
                'Success!',
                'Unit updated!',
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
          this.$router.push('/pmsunits/'+this.form.pms_property_id)
       },
       back(){
         this.$router.push('/pmsunits/'+this.form.pms_property_id)
       }
 
    },
    mounted() {
      this.getUnit()
    }
 
 }
 </script>
    
 
 
