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
                      <h5 class="card-title">All Landlords <span>| Today</span></h5>
                      <p class="card-text">
                        <div class="row">
                          <div class="col d-flex">
                   
                   
                            <router-link to="/add-pmslandlord" custom v-slot="{ href, navigate, isActive }">
                                <a
                                  :href="href"
                                  :class="{ active: isActive }"
                                  class="btn btn-sm btn-primary rounded-pill"
                                  style="background-color: darkgreen; border-color: darkgreen;"
                                  @click="navigate"
                                >
                                  Add Landlord
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
    
                      <table id="AlllandlordsTable" class="table table-borderless">
                        <thead>
                          <tr>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Phone No.</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="landlord in landlords" :key="landlord.id">
                            <td>{{landlord.first_name}} {{landlord.last_name}}</td>
                            <td>{{landlord.email ?? "N/A"}}</td>
                            <td>{{landlord.phone_no ?? "N/A"}}</td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <!-- <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>  -->
                                  <a @click="navigateTo('/pmslandlordproperties/'+landlord.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View Property</a>
                                   <a @click="navigateTo('/pmslandlordstatements/'+landlord.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View Statements</a>                                           
                                  <a @click="navigateTo('/edit-pmslandlord/'+landlord.id )" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                                  <a @click="deleteLandlord(landlord.id)" class="dropdown-item" href="#"><i class="ri-delete-bin-line mr-2"></i>Delete</a>
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
          landlords: [],
          categories: [],
          landlordtypes: [],
          user: []
        }
      },
      methods: {
        getPhoto()
        {
            return "/storage/landlords/";
        },
        navigateTo(location){
            this.$router.push(location)
        },
        deleteLandlord(id){
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
                  axios.delete('/api/landlord/'+id).then(() => {
                  toast.fire(
                    'Deleted!',
                    'Landlord has been deleted.',
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
             this.landlords = response.data.lists.landlords;
             console.log("props", response)
             setTimeout(() => {
                  $("#AlllandlordsTable").DataTable();
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
    
    
    