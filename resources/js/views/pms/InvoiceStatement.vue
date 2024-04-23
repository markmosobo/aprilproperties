<template>
   <TheMaster>
   <div class="card px-2">
       <div class="card-body">
       <h5 class="card-title">Invoice Tenant</h5>

       <!-- Vertical Form -->
       <form class="row g-3">
           <div class="col-12">
           <label for="inputNanme4" class="form-label">Water Bill</label>
           <input type="number" v-model="form.water_bill" class="form-control" id="inputNanme4">
           </div>

           <div class="col-lg-12 felx mt-4 row">
                   <div class="col-sm-6 col-lg-6">
                       <button @click.prevent="prev()" class="btn btn-dark rounded-pill">Back</button>
                   </div>
                   <div class="col-sm-6 col-lg-6 text-end">
                       <button type="submit" style="background-color: darkgreen; border-color: darkgreen;" @click.prevent="submit()" class="btn rounded-pill btn-primary">Submit</button>
                   </div>
               </div>
       </form><!-- Vertical Form -->

       </div>
   </div>
</TheMaster>
</template>

<script>
import axios from "axios";
import Swal from 'sweetalert2';
import TheMaster from "@/components/dashboard/TheMaster.vue";


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
          water_bill: 0.00,  
       },
         message: "",
         successMessage: "",
         loading: false,
      }   
   },
   methods: {
      prev(){
         this.$router.push('/statements')
      },
      submit(){
         axios.put("/api/pmsinvoicestatement/"+this.$route.params.id, this.form)
         .then(function (response) {
            console.log(response);
            // this.step = 1;
            toast.fire(
               'Success!',
               'Tenant invoiced!',
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
         this.$router.push('/statements')

      }

   },
   mounted() {
   }

}
</script>