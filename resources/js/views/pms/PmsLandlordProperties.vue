<template>
    <TheMaster>
        <section class="section dashboard">
          <div class="row">
    
                <!-- Top Selling -->
                <div class="col-12">
                  <div class="card top-selling overflow-auto">
    
                    <div class="filter">
<!--                       <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                          <h6>Filter</h6>
                        </li>
    
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                      </ul> -->
                    </div>
    
                    <div class="card-body pb-0">
                      <h5 class="card-title">{{landlord}}'s Managed Properties <span>| Today</span></h5>
                      <p class="card-text">
                        <div class="row">
                        <div class="col d-flex">
                       
                          <router-link to="/add-pmsproperty" custom v-slot="{ href, navigate, isActive }">
                              <a
                                :href="href"
                                :class="{ active: isActive }"
                                class="btn btn-sm btn-primary rounded-pill"
                                style="background-color: darkgreen; border-color: darkgreen;"
                                @click="navigate"
                              >
                                Add Property
                              </a>
                          </router-link>
                        </div>
                        <div class="col-auto d-flex justify-content-end">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="ri-add-line"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                  <a @click="navigateTo('/managedproperties' )" class="dropdown-item" href="#"><i class="ri-building-fill mr-2"></i>Properties</a>
                                  <a @click="navigateTo('/pmslandlords' )" class="dropdown-item" href="#"><i class="ri-user-fill mr-2"></i>Landlords</a>
                                  <a @click="navigateTo('/pmstenants' )" class="dropdown-item" href="#"><i class="ri-user-fill mr-2"></i>Tenants</a>
                            </div>
                          </div>
                        </div>
                      </div>  

            
                      </p>
    
                      <table id="AllPropertiesTable" class="table table-borderless">
                        <thead>
                          <tr>
                            <!--<th scope="col">Preview</th>-->
                            <th scope="col">Name</th>
                            <th scope="col">Number of Units</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="property in properties" :key="property.id">
                            <!--<th scope="row"><a href="#">
                              <img :src="getPhoto() + property.images[0].name" />
                            </a></th>-->
                            <!-- <td>{{property["images"][0]["name"]}}</td> -->
                            <td>{{property.name}}</td>
                            <td>{{property.units.length}}</td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a @click="navigateTo('/pmsproperties/'+property.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>                                            
                                  <a @click="navigateTo('/pmsunits/'+property.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View Units</a>
                                  <!-- <a @click="navigateTo('/pmspropertystatements/'+property.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View Statements</a>  -->
                                  <a @click="navigateTo('/propertyallsettledinvoices/'+property.id)" class="dropdown-item" href="#">
                                    <i class="ri-bank-card-fill mr-2"></i>View Invoices
                                  </a>
 
                                  <a @click="navigateTo('/edit-pmsproperty/'+property.id )" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a> 
                                  <a @click="deleteProperty(property.id)" class="dropdown-item" href="#"><i class="ri-delete-bin-line mr-2"></i>Delete</a>
                                 
                                  </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
    
                    </div>
    
                  </div>
                </div><!-- End Top Selling -->
    
            </div>
        </section>
    </TheMaster>
    </template>
    
    <script>
     import TheMaster from "@/components/dashboard/TheMaster.vue";
     import axios from "axios";
    import Swal from 'sweetalert2';
    import "jquery/dist/jquery.min.js";
    import "datatables.net-dt/js/dataTables.dataTables";
    import "datatables.net-dt/css/jquery.dataTables.min.css";
    import $ from "jquery";
    
    const toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    
    window.toast = toast;
    
    export default {
      data(){
        return {
          properties: [],
          categories: [],
          landlord: [],
          user: []
        }
      },
      methods: {
        getPhoto()
        {
            return "/storage/properties/";
        },
        getLandlord()
        {
            axios.get('/api/landlord/'+this.$route.params.id).then((response) => {
                this.landlord = response.data.landlord
                this.landlord = this.landlord.first_name + " " + this.landlord.last_name;
                console.log("user", this.landlord)
            })
        },
        getLandlordProperties()
        {
            axios.get('/api/landlordproperty/'+this.$route.params.id).then((response) => {
                this.properties = response.data.landlordproperty
                console.log("lprops", response)
            })
        },
        navigateTo(location){
            this.$router.push(location)
        },

        featureProperty(id){
          axios.put('api/featureproperty/'+ id).then(() => {
            toast.fire(
              'Successful',
              'Property has been featured',
              'success'
            ); 
            this.loadLists();                    
          }).catch(() => {
              console.log('error')
          })
        },
        unfeatureProperty(id){
          axios.put('api/unfeatureproperty/'+ id).then(() => {
            toast.fire(
              'Successful',
              'Property has been unfeatured',
              'success'
            ); 
            this.loadLists();                    
          }).catch(() => {
              console.log('error')
          })
        },
        closeProperty(id){
          axios.put('api/closeproperty/'+ id).then(() => {
            toast.fire(
              'Successful',
              'Property has been closed',
              'success'
            ); 
            this.loadLists();                    
          }).catch(() => {
              console.log('error')
          })
        },
        reopenProperty(id){
          axios.put('api/reopenproperty/'+ id).then(() => {
            toast.fire(
              'Successful',
              'Property has been reopened',
              'success'
            ); 
            this.loadLists();                    
          }).catch(() => {
              console.log('error')
          })
        },
        deleteProperty(id){
                Swal.fire({
                  title: 'Are you sure?',
                  text: "All units associated with property will be deleted. You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#006400',
                  cancelButtonColor: '#FFA500',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  axios.delete('/api/pmsproperty/'+id).then(() => {
                  toast.fire(
                    'Deleted!',
                    'Property has been deleted.',
                    'success'
                  )
                  this.loadLists();
                  }).catch(() => {
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
        },
      },
      components : {
          TheMaster,
      },
      mounted(){
        this.getLandlordProperties();
        this.getLandlord();
        this.user = localStorage.getItem('user');
        this.user = JSON.parse(this.user);

      }
    }
    </script>
    
    
    