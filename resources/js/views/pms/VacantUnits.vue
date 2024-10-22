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
                      <h5 class="card-title">Vacant Units <span>| Vacant units</span></h5>
                      <p class="card-text"> 
                      <div class="row">
                          <div class="col d-flex">                
                          <a
                            class="btn btn-sm btn-primary rounded-pill active"
                            v-if="addUnitPermission"
                            style="background-color: darkgreen; border-color: darkgreen;"
                            @click="navigateTo('/add-pmsunit/'+unit.id )"
                          >
                            Add Unit
                          </a>
                          </div>
                          <div class="col-auto d-flex justify-content-end">
                          <div class="btn-group" role="group">
                              <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-add-line"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                     <a @click="navigateTo('/managedproperties' )" class="dropdown-item" href="#"><i class="ri-building-fill mr-2"></i>Properties</a>
                                     <a @click="navigateTo('/pmstenants' )" class="dropdown-item" href="#"><i class="ri-user-fill mr-2"></i>Tenants</a>
                                    <a @click="navigateTo('/pmslandlords' )" class="dropdown-item" href="#"><i class="ri-user-fill mr-2"></i>Landlords</a>
                                </div>
                              </div>
                            </div>
                        </div>
            
                      </p>
    
                      <table id="AllPropertiesTable" class="table table-borderless">
                        <thead>
                          <tr>
                            <!--<th scope="col">Preview</th>-->
                            <th scope="col">Unit Number</th>
                            <th scope="col">Type</th>
                            <th scope="col">Deposit</th>
                            <th scope="col">Rent(monthly)</th>
                            <th scope="col">Property</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="unit in vacantunits" :key="unit.id">
                            <!--<th scope="row"><a href="#">
                              <img :src="getPhoto() + property.images[0].name" />
                            </a></th>-->
                            <!-- <td>{{property["images"][0]["name"]}}</td> -->
                            <td>{{unit.unit_number ?? 'N/A'}}</td>
                            <td>{{unit.type ?? 'N/A'}}</td>
                            <td>{{unit.deposit ?? 'N/A'}}</td>
                            <td>{{unit.monthly_rent ?? 'N/A'}}</td>
                            <td>{{unit.property.name ?? 'N/A'}}</td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a @click="navigateTo('/view-pmsunit/'+unit.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a> 
                                  <a v-if="editUnitPermission" @click="navigateTo('/edit-pmsunit/'+unit.id )" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>                                           
                                  <a v-if="deleteUnitPermission" @click="deleteUnit(unit.id)" class="dropdown-item" href="#"><i class="ri-delete-bin-line mr-2"></i>Delete</a>
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
          vacantunits: [],
          categories: [],
          propertytypes: [],
          user: [],
          unit: [],
          addUnitPermission: '',
          editUnitPermission: '',
          deleteUnitPermission: ''
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
        getProperty() {
             axios.get('/api/pmsproperty/'+this.$route.params.id).then((response) => {
     
             this.unit = response.data.property;
             console.log("props", this.unit)
    
             });
        },
        deleteUnit(id){
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
                  axios.delete('/api/pmsunit/'+id).then(() => {
                  toast.fire(
                    'Deleted!',
                    'Unit has been deleted.',
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
        getUserPermissions(id) {
          axios.get('/api/userpermissions/' + id)
            .then((response) => {
              this.permissions = response.data.permissions;
              console.log("vee", this.permissions)

              // Define the permission id you want to check for
              const requiredAddPermissionId = 19;
              const requiredEditPermissionId = 20;
              const requiredDeletePermissionId = 21;
              const requiredStatus = 1;

              // Check if the user has the required permissions
              const hasAddPermission = this.permissions.some(permission => 
                permission.permission_id === requiredAddPermissionId && permission.status === requiredStatus);

              const hasEditPermission = this.permissions.some(permission => 
                permission.permission_id === requiredEditPermissionId && permission.status === requiredStatus);

              const hasDeletePermission = this.permissions.some(permission => 
                permission.permission_id === requiredDeletePermissionId && permission.status === requiredStatus);

              if (hasAddPermission) {
                // User has the required permission, allow them to view things
                this.addUnitPermission = true;
                console.log(`User has permission: ${this.addUnitPermission}`);
              } else {
                // User does not have the required permission
                this.addUnitPermission = false;
                console.log('User does not have the required permission');
              }

              if (hasEditPermission) {
                // User has the required permission, allow them to view things
                this.editUnitPermission = true;
                console.log(`User has permission: ${this.editUnitPermission}`);
              } else {
                // User does not have the required permission
                this.editUnitPermission = false;
                console.log('User does not have the required permission');
              }

              if (hasDeletePermission) {
                // User has the required permission, allow them to view things
                this.deleteUnitPermission = true;
                console.log(`User has permission: ${this.deleteUnitPermission}`);
              } else {
                // User does not have the required permission
                this.deleteUnitPermission = false;
                console.log('User does not have the required permission');
              }
              })
              .catch(error => {
                console.error('Error fetching permissions:', error);
              });
        },
        loadLists() {
             axios.get('/api/lists').then((response) => {
     
             this.vacantunits = response.data.lists.vacantunits;
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
        // this.getProperty();
        this.user = localStorage.getItem('user');
        this.user = JSON.parse(this.user);
        this.userId = this.user.id;
        this.getUserPermissions(this.userId);

      }
    }
    </script>
    
    
    