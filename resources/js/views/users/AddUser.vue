<template>
    <TheMaster>
        <div class="card px-2">
       <div class="card-body">
          <!-- General Form Elements -->
          <form @submit.prevent="">
          <fieldset v-if="step == 1">
             <h5 class="card-title text-center">Add user</h5>
 
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
                      <label for="inputPassword" class="form-label">Last Name</label>
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
                      <label for="inputPassword" class="form-label">Email Address</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Email Address"
                            id="title"
                            name="title"
                            v-model="form.email"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="validationCustom04" class="form-label"
                      >Role</label
                      >
                      <div class="col-sm-10">
                         <select name="role" v-model="form.role_id" class="form-select" id="">
                            <option value="0" selected>Select Role</option>
                            <option v-for="role in roles" :value="role.id"
                            :selected="role.id == form.role_id" :key="role.id">{{ role.name}}</option>
 
                         </select>
 
                      <div class="invalid-feedback">Please enter role!</div>
                      </div>
                   </div>

                </div>

             </div>

          <p class="mt-3">Users should change it after first time login. The default password is: <strong>aprilproperties</strong></p>

             <!--  button -->
             <div class="col-lg-12 felx mt-4 row">
                <div class="col-sm-6 col-lg-6">
                    <!-- <button @click.prevent="prev()" class="btn btn-dark">Previous</button> -->
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
          password: 'password'
          
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
       loadLists() {
          axios.get('api/lists').then((response) => {
          this.roles = response.data.lists.roles;
 
          });
       },
       submit(){
          axios.post("api/users", this.form)
          .then(function (response) {
             console.log(response);
             // this.step = 1;
             toast.fire(
                'Success!',
                'User added!',
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
          this.$router.push('/all-users')
       }
 
    },
    mounted() {
       this.loadLists();
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
 
 .picture {
    width: 106px;
    height: 106px;
    background-color: #99999;
    border: 4px solid #CCCCCC;
    color: #FFFFFF;
    border-radius: 50%;
    margin: 0px auto;
    overflow: hidden;
    transition: all 0.2s;
    -webkit-transition: all 0.2s;
 }
 
 .picture:hover {
    border-color: #2ca8ff;
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