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
                      <h5 class="card-title">All Statements <span>| Today</span></h5>
                      <p class="card-text">
                   
<!--                       <router-link to="/add-pmslandlord" custom v-slot="{ href, navigate, isActive }">
                          <a
                            :href="href"
                            :class="{ active: isActive }"
                            class="btn btn-sm btn-primary rounded-pill"
                            @click="navigate"
                          >
                            Add Landlord
                          </a>
                      </router-link> -->
            
                      </p>
    
                      <table id="AllStatementsTable" class="table table-borderless">
                        <thead>
                          <tr>
                            <th scope="col">Transaction On</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Status</th>
                            <th scope="col">Detail</th>
                            <th scope="col">Property</th>
                            <th scope="col">Total</th>
                            <th scope="col">Paid</th>
                            <th scope="col">Bal</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="statement in statements" :key="statement.id">
                            <td>{{format_date(statement.created_at)}}</td>
                            <td>{{statement.ref_no}}</td>
                            <td v-if="statement.status == 1">Paid</td>
                            <td v-else>Not Paid</td>
                            <td>{{statement.details}}</td>
                            <td>{{statement.property.name}}</td>
                            <td>{{formatNumber(statement.total)}}</td>
                            <td>{{formatNumber(statement.paid)}}</td>
                            <td>{{formatNumber(statement.balance)}}</td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a @click="navigateTo('/viewstatement/'+statement.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>                                            
                                  <!-- <a v-if="user.id == 1" @click="navigateTo('/editstatement/'+statement.id )" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a> -->
                                  <a @click="settleTenant(statement.id)" class="dropdown-item" href="#"><i class="ri-check-fill mr-2"></i>Settle</a>
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
          statements: [],
          user: []
        }
      },
      methods: {
        navigateTo(location){
            this.$router.push(location)
        },
        settleTenant(id){
            this.$router.push(location)
        },
        formatNumber(value) {
          // Use the toLocaleString method to format the number with commas and decimal places
          return value.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });
        },
        format_date(value){
          if(value){
            return moment(String(value)).format('lll')
          }
        },
        loadLists() {
             axios.get('api/lists').then((response) => {
             this.statements = response.data.lists.statements;
             console.log("props", response)
             setTimeout(() => {
                  $("#AllStatementsTable").DataTable();
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
    
    
    