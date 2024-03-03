<template>
    <TheMaster>
        <section class="section dashboard">
          <div class="row">
    
                <!-- Top Selling -->
                <div class="col-12">
                  <div class="card top-selling overflow-auto">
    
                    <div class="filter">
                      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                          <h6>Filter</h6>
                        </li>
    
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                      </ul>
                    </div>
    
                    <div class="card-body pb-0">
                      <h5 class="card-title">{{unit.name}} Units <span>| Today</span></h5>
                      <p class="card-text">                 
                          <a
                            class="btn btn-sm btn-primary rounded-pill active"
                            @click="navigateTo('/add-pmsunit/'+unit.id )"
                          >
                            Add Unit
                          </a>
            
                      </p>
    
                      <table id="AllPropertiesTable" class="table table-borderless">
                        <thead>
                          <tr>
                            <!--<th scope="col">Preview</th>-->
                            <th scope="col">Unit Number</th>
                            <th scope="col">Type</th>
                            <th scope="col">Deposit</th>
                            <th scope="col">Rent(monthly)</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="property in properties" :key="property.id">
                            <!--<th scope="row"><a href="#">
                              <img :src="getPhoto() + property.images[0].name" />
                            </a></th>-->
                            <!-- <td>{{property["images"][0]["name"]}}</td> -->
                            <td>{{property.unit_number ?? 'N/A'}}</td>
                            <td>{{property.type ?? 'N/A'}}</td>
                            <td>{{property.deposit ?? 'N/A'}}</td>
                            <td>{{property.monthly_rent ?? 'N/A'}}</td>
                            <td>
                              <span v-if="property.status == 0" class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Vacant</span>   
                              <span v-else-if="property.status == 1" class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Occupied</span>
                              <span v-else class="badge bg-light text-dark"><i class="bi bi-star me-1"></i> Closed</span>                              
                            </td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a @click="navigateTo('/view-pmsunit/'+property.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a> 
                                  <a @click="navigateTo('/edit-pmsunit/'+property.id )" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>                                           
                                  <a @click="deleteUnit(property.id)" class="dropdown-item" href="#"><i class="ri-delete-bin-line mr-2"></i>Delete</a>
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
          propertytypes: [],
          user: [],
          unit: []
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
     
             this.unit = response.data.property[0];
             console.log("props", this.unit)
    
             });
        },
        deleteUnit(id){
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
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
        loadLists() {
             axios.get('/api/pmsunits/'+this.$route.params.id).then((response) => {
     
             this.properties = response.data.units;
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
        this.getProperty();
        this.user = localStorage.getItem('user');
        this.user = JSON.parse(this.user);

      }
    }
    </script>
    
    
    