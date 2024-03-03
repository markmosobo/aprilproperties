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
                      <h5 class="card-title">All Users <span>| Today</span></h5>
                      <p class="card-text">
                   
                      <router-link to="/add-user" custom v-slot="{ href, navigate, isActive }">
                          <a
                            :href="href"
                            :class="{ active: isActive }"
                            class="btn btn-sm btn-success rounded-pill"
                            @click="navigate"
                          >
                            Add User
                          </a>
                      </router-link>
            
                      </p> 
    
                      <table id="AllUsersTable" class="table table-borderless">
                        <thead>
                          <tr>
                            <!-- <th scope="col">Preview</th> -->
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col">Registered On</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="user in users" :key="user.id">
                            <td>{{user.first_name}} {{user.last_name}}</td>
                            <td>{{(user.email)}}</td>
                            <td>{{user.phone ?? 'N/A'}}</td>
                            <td>{{user.role['name']}}</td>
                            <td>
                              <span v-if="user.status == 0" class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Pending</span>   
                              <span v-else-if="user.status == 1" class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                              <span v-else class="badge bg-light text-dark"><i class="bi bi-star me-1"></i> Inactive</span>

                            </td>
                            <td>{{format_date(user.created_at)}}</td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-success rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a @click="navigateTo('/viewuser/'+user.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>                                            
                                  <a v-if="user.status == 2" @click="activateUser(user.id)" class="dropdown-item" href="#"><i class="ri-eye-close-fill mr-2"></i>Activate</a>
                                  <a v-if="user.status == 1" @click="deactivateUser(user.id)" class="dropdown-item" href="#"><i class="ri-refresh-fill mr-2"></i>Deactivate</a>
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
    import moment from 'moment';

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
          users: [],
          user: []
        }
      },
      methods: {
        format_date(value){
          if(value){
            return moment(String(value)).format('MMM Do YYYY')
          }
        },
        getPhoto()
        {
            return "users/";
        },
        navigateTo(location){
            this.$router.push(location)
        },
        activateUser(id){
          axios.put('api/activateuser/'+ id).then(() => {
            toast.fire(
              'Successful',
              'User has been activated',
              'success'
            ); 
            this.loadLists();                    
          }).catch(() => {
              console.log('error')
          })
        },
        deactivateUser(id){
          axios.put('api/deactivateuser/'+ id).then(() => {
            toast.fire(
              'Successful',
              'User has been deactivated',
              'success'
            ); 
            this.loadLists();                    
          }).catch(() => {
              console.log('error')
          })
        },
        loadLists() {
             axios.get('api/lists').then((response) => {
             this.users = response.data.lists.users;
             console.log(this.users)
             setTimeout(() => {
                  $("#AllUsersTable").DataTable();
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
    
    
    