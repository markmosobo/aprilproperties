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
                      <h5 class="card-title">All Tenants <span>| Today</span></h5>
                      <p class="card-text">
                         <div class="row">
                          <div class="col d-flex">
                   
                            <router-link to="/add-pmstenant" custom v-slot="{ href, navigate, isActive }">
                                <a
                                  :href="href"
                                  :class="{ active: isActive }"
                                  class="btn btn-sm btn-primary rounded-pill"
                                  style="background-color: darkgreen; border-color: darkgreen;"
                                  @click="navigate"
                                >
                                  Add Tenant
                                </a>
                            </router-link>

                 <!--            <router-link to="/add-pmscurrenttenant" custom v-slot="{ href, navigate, isActive }">
                                <a
                                  :href="href"
                                  :class="{ active: isActive }"
                                  class="btn btn-sm btn-primary rounded-pill"
                                  style="background-color: orange; border-color: orange;"
                                  @click="navigate"
                                >
                                  Add Renting Tenant
                                </a>
                            </router-link> -->
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
                            <th scope="col">Full Name</th>
                            <th scope="col">Property</th>
                            <th scope="col">Unit No</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="tenant in tenants" :key="tenant.id">
                            <td>{{tenant.first_name}} {{tenant.last_name}}</td>
                            <td>{{tenant.property.name}}</td>
                            <td>{{tenant.unit.unit_number}}</td>
                            <td>
                              <span v-if="tenant.status == 0" class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Vacated</span>   
                              <span v-else-if="tenant.status == 1" class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Renting</span>
                              <span v-else class="badge bg-light text-dark"><i class="bi bi-star me-1"></i> Closed</span>

                            </td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a class="dropdown-item" @click="navigateTo('/pmstenant/'+tenant.id )" href="#"><i class="ri-eye-fill mr-2"></i>View</a>                                            
                                  <!-- <a @click="navigateTo('/pmstenantstatements/'+tenant.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View Statements</a> -->
                                  <a @click="navigateTo('/pmstenantinvoices/'+tenant.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View Invoices</a>
                                  <a @click="navigateTo('/edit-pmstenant/'+tenant.id )" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                                  <a v-if="tenant.status == 1" @click="vacateTenant(tenant.id)" class="dropdown-item" href="#"><i class="ri-eye-close-fill mr-2"></i>Vacate</a>
                                  <a v-if="tenant.status == 2" @click="reopenTenant(tenant.id)" class="dropdown-item" href="#"><i class="ri-refresh-fill mr-2"></i>Reopen</a>
                                  <a @click="deleteTenant(tenant.id)" class="dropdown-item" href="#"><i class="ri-delete-bin-line mr-2"></i>Delete</a>
                                  </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <!--show total tenants-->
                        <div><strong>Total Tenants: {{tenants.length}}</strong></div>
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
          tenants: [],
          categories: [],
          user: []
        }
      },
      methods: {
        getPhoto()
        {
            return "/storage/properties/";
        },
        navigateTo(location){
            this.$router.push(location)
        },
        vacateTenant(id){
          axios.put('api/vacatetenant/'+ id).then(() => {
            toast.fire(
              'Successful',
              'Tenant has been vacated',
              'success'
            ); 
            this.loadLists();                    
          }).catch(() => {
              console.log('error')
          })
        },
        reopenTenant(id){
          axios.put('api/reopentenant/'+ id).then(() => {
            toast.fire(
              'Successful',
              'tenant has been reopened',
              'success'
            ); 
            this.loadLists();                    
          }).catch(() => {
              console.log('error')
          })
        },
        deleteTenant(id){
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#006400',
                  cancelButtonColor: '#FFA500',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  axios.delete('/api/pmstenant/'+id).then(() => {
                  toast.fire(
                    'Deleted!',
                    'Tenant has been deleted.',
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
        loadLists() {
             axios.get('api/lists').then((response) => {

             this.tenants = response.data.lists.pmstenants;
             console.log("props", response)
             setTimeout(() => {
                  $("#AllPropertiesTable").DataTable();
              }, 10);
    
             });
          },
      },
      components : {
          TheMaster,
      },
      mounted(){
        this.loadLists();
        this.user = localStorage.getItem('user');
        this.user = JSON.parse(this.user);

      }
    }
    </script>
    
    
    