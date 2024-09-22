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
                      <h5 class="card-title">Payment Methods<span>| Payments methods to pay April Properties</span></h5>
                      <p class="card-text">
                         <div class="row">
                          <div class="col d-flex">
                   
                            <router-link to="#" custom v-slot="{ href, navigate, isActive }">
                                <a
                                  :href="href"
                                  :class="{ active: isActive }"
                                  class="btn btn-sm btn-primary rounded-pill"
                                  style="background-color: darkgreen; border-color: darkgreen;"
                                  @click="openModal"
                                >
                                  Add Payment Method
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
                            <th scope="col">Account Name</th>
                            <th scope="col">Account No.</th>
                            <th scope="col">Transfer Type</th>
                            <th scope="col">Paybill</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="payment in payments" :key="payment.id">
                            <td>{{payment.account_name ?? "N/A"}}</td>
                            <td>{{payment.account_number ?? "N/A"}}</td>
                            <td>{{payment.transfer_type ?? "N/A"}}</td>
                            <td>{{payment.paybill ?? "N/A"}}</td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a class="dropdown-item" @click="viewPayment(payment)" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                                  <a @click="editPayment(payment)" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                                  <a v-if="payment.id !== 1" @click="deletePayment(payment.id)" class="dropdown-item" href="#"><i class="ri-delete-bin-line mr-2"></i>Delete</a>
                                  </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <!--show total tenants-->
                        <div><strong>Payment Methods: {{payments.length}}</strong></div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewPaymentModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="viewPaymentModalLabel">View Payment Method</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p v-if="selectedPayment">
                              <strong>Account Name:</strong> {{ selectedPayment.account_name }}
                            </p>
                            <p v-if="selectedPayment">
                              <strong>Transfer Type:</strong> {{ selectedPayment.transfer_type }}
                            </p>
                            <p v-else>
                              <strong>Transfer Type:</strong> N/A
                            </p>
                            <p v-if="selectedPayment.bank_name">
                              <strong>Bank Name:</strong> {{ selectedPayment.bank_name }}
                            </p>
                            <p v-else>
                              
                            </p>
                            <p v-if="selectedPayment.paybill_number">
                              <strong>Paybill Number:</strong> {{ selectedPayment.paybill_number }}
                            </p>
                            <p v-else>
                              
                            </p>
                            <p v-if="selectedPayment.till_number">
                              <strong>Till Number:</strong> {{ selectedPayment.till_number }}
                            </p>
                            <p v-else>
                              
                            </p>
                            
                            <p v-if="selectedPayment.bank_name">
                              <strong>Bank Name:</strong> {{ selectedPayment.bank_name }}
                            </p>
                            <p v-else>
                              
                            </p>

                            <p v-if="selectedPayment.account_number">
                              <strong>Account Number:</strong> {{ selectedPayment.account_number }}
                            </p>
                            <p v-else>
                              <strong>Account Number:</strong> N/A
                            </p>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Add PaymentModal -->
                    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="addPaymentModalLabel">Create Payment Method</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <!-- Modal body content -->
                            <div class="modal-body">
                              <p>
                                <strong>Account Name:</strong>
                                <input type="text" name="account_name" v-model="form.account_name" class="form-control">
                                <div v-if="errors.account_name" class="text-danger">{{ errors.account_name }}</div>
                              </p> 
                              <p>
                                <strong>Transfer Type:*</strong>
                                <select v-model="form.transfer_type" class="form-control" size="5">
                                  <option value="Bank Transfer">
                                    Bank Transfer 
                                  </option>
                                  <option value="Mpesa Till Number">
                                    MPESA Till Number
                                  </option>
                                  <option value="Mpesa Paybill">
                                    MPESA Paybill
                                  </option>
                                </select>
                                <div v-if="errors.transfer_type" class="text-danger">{{ errors.transfer_type }}</div>
                              </p>

                              <p v-if="form.transfer_type == 'Bank Transfer'">
                                <strong>Bank Name:</strong>
                                <input type="text" name="bank_name" v-model="form.bank_name" class="form-control">
                                <div v-if="errors.bank_name" class="text-danger">{{ errors.bank_name }}</div>
                              </p>

                              <p v-if="form.transfer_type == 'Mpesa Till Number'">
                                <strong>Till Number:</strong>
                                <input type="text" name="till_number" v-model="form.till_number" class="form-control">
                                <div v-if="errors.till_number" class="text-danger">{{ errors.till_number }}</div>
                              </p>

                              <p v-if="form.transfer_type == 'Mpesa Paybill'">
                                <strong>Paybill Number:</strong>
                                <input type="text" name="paybill_number" v-model="form.paybill_number" class="form-control">
                                <div v-if="errors.paybill_number" class="text-danger">{{ errors.paybill_number }}</div>
                              </p>

                              <p v-if="form.transfer_type == 'Mpesa Paybill' || form.transfer_type == 'Bank Transfer'">
                                <strong>Account Number:</strong>
                                <input type="text" name="account_number" v-model="form.account_number" class="form-control">
                                <div v-if="errors.account_number" class="text-danger">{{ errors.account_number }}</div>
                              </p> 
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
                            <!-- Additional buttons or actions -->
                            <button type="button" @click="createPayment" class="btn btn-primary" style="background-color: darkgreen; border-color: darkgreen;">Save</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!--Edit Payment Modal -->
                    <div class="modal fade" id="EditPaymentModal" tabindex="-1" aria-labelledby="EditPaymentModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="EditPaymentModalLabel">Edit Payment Method</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>#{{selectedPayment.account_name}}</p>
                              <p>
                                <strong>Account Name:</strong>
                                <input type="text" name="account_name" v-model="form.account_name" class="form-control">
                                <div v-if="errors.account_name" class="text-danger">{{ errors.account_name }}</div>
                              </p>
                              <p>
                                <strong>Transfer Type:*</strong>
                                <select v-model="form.transfer_type" class="form-control" size="5">
                                  <option value="Bank Transfer">
                                    Bank Transfer 
                                  </option>
                                  <option value="Mpesa Till Number">
                                    MPESA Till Number
                                  </option>
                                  <option value="Mpesa Paybill">
                                    MPESA Paybill
                                  </option>
                                </select>
                                <div v-if="errors.transfer_type" class="text-danger">{{ errors.transfer_type }}</div>
                              </p>

                              <p v-if="form.transfer_type == 'Bank Transfer'">
                                <strong>Bank Name:</strong>
                                <input type="text" name="bank_name" v-model="form.bank_name" class="form-control">
                                <div v-if="errors.bank_name" class="text-danger">{{ errors.bank_name }}</div>
                              </p>

                              <p v-if="form.transfer_type == 'Mpesa Till Number' && form.transfer_type !== 'Mpesa Paybill'">
                                <strong>Till Number:</strong>
                                <input type="text" name="till_number" v-model="form.till_number" class="form-control">
                                <div v-if="errors.till_number" class="text-danger">{{ errors.till_number }}</div>
                              </p>

                              <p v-if="form.transfer_type == 'Mpesa Paybill'">
                                <strong>Paybill Number:</strong>
                                <input type="text" name="paybill_number" v-model="form.paybill_number" class="form-control">
                                <div v-if="errors.paybill_number" class="text-danger">{{ errors.paybill_number }}</div>
                              </p>
 
                              <p>
                                <strong>Account Number:</strong>
                                <input type="text" name="account_number" v-model="form.account_number" class="form-control">
                                <div v-if="errors.account_number" class="text-danger">{{ errors.account_number }}</div>
                              </p>                          

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-primary" @click.prevent="confirmEditPayment">Save changes</button>
                          </div>
                        </div>
                      </div>
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
          payments: [],
          categories: [],
          user: [],
          addTenantPermission: '',
          editTenantPermission: '',
          deleteTenantPermission: '',
          vacateTenantPermission: '',
          selectedPayment: {},

          form: {
            transfer_type : '',
            account_name: '',
            bank_name: '',
            account_number: '',
            paybill_number: '',
            till_number: ''
          },
          errors: {
            transfer_type : '',
            account_name: '',
            bank_name: '',
            account_number: '',
            paybill_number: '',
            till_number: ''
          },
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
        viewPayment(payment) {
          this.selectedPayment = payment;

          const modal = new bootstrap.Modal(document.getElementById('viewPaymentModal'));
          modal.show();
        },
        openModal() {
          //reset form 
          this.form.transfer_type = '';
          this.form.bank_name = '';
          this.form.account_name = '';
          this.form.account_number = '';
          this.form.paybill_number = '';
          this.form.till_number = '';
          //reset error
          this.errors.transfer_type = '';
          this.errors.bank_name = '';
          this.errors.account_name = '';
          this.errors.account_number = '';
          this.errors.paybill_number = '';
          this.errors.till_number = '';
          // $('#addPaymentModal').modal('show'); // Show the modal using jQuery
          const modal = new bootstrap.Modal(document.getElementById('addPaymentModal'));
          modal.show();
        },
        closeModal() {
          // $('#addPaymentModal').modal('hide'); // Hide the modal using jQuery
          const modal = bootstrap.Modal.getInstance(document.getElementById('addPaymentModal'));
          modal.hide();
        },
        createPayment()
        {
          // Validate payment
          if (!this.form.transfer_type) {
            this.errors.transfer_type = 'Transfer type is required.';
            return;
          }

          // Validate account name
          if (this.form.transfer_type == 'Bank Transfer' && !this.form.account_name) {
            this.errors.account_number = 'Account number is required.';
            return;
          }

          console.log(this.form)
          axios.post("/api/payment", this.form)
              .then(response => {
                this.successMessage = 'Payment method created!';
                toast.fire(
                  'Success!',
                  'Payment method created!',
                  'success'
                );
              })
              .catch(error => {
                console.log(error);
                // Handle the error appropriately
                toast.fire(
                  'Error!',
                  error.response.data.message,
                  'error'
                );
              })
              .finally(() => {
                // Hide loading spinner
                this.loading = false;

                // Close the modal after invoicing
                const modal = bootstrap.Modal.getInstance(document.getElementById('addPaymentModal'));
                modal.hide();

                // Reset form
                this.form.transfer_type = '';
                this.form.bank_name = '';
                this.form.account_name = '';
                this.form.account_number = '';
                this.form.paybill_number = '';
                this.form.till_number = '';
                this.loadLists();

              });

        },
        editPayment(payment)
        {
          this.selectedPayment = payment;
          this.form.account_name = this.selectedPayment.account_name;
          this.form.account_number = this.selectedPayment.account_number;
          this.form.paybill = this.selectedPayment.paybill;
          this.form.transfer_type = this.selectedPayment.transfer_type;

          // Show the modal after fetching data
            const modal = new bootstrap.Modal(document.getElementById('EditPaymentModal'));
            modal.show();
        },
        async confirmEditPayment() {
          if (this.selectedPayment && this.selectedPayment.id) {
            // Implement your logic to edit payment method here
            console.log("Editing payment with payment ID:", this.selectedPayment.id);
            await this.saveEditPayment();

            // Close the modal after invoicing
            const modal = bootstrap.Modal.getInstance(document.getElementById('EditPaymentModal'));
            modal.hide();
            this.loadLists()
          }
        },
        saveEditPayment() {
            return new Promise((resolve, reject) => {
                let payload; // Define payload variable outside the if-else blocks

                  payload = {
                      account_name: this.form.account_name,
                      account_number: this.form.account_number,
                      transfer_type: this.form.transfer_type,
                      paybill: this.form.paybill,
                  };
               

                axios.put("/api/payment/" + this.selectedPayment.id, payload)
                    .then(response => {
                        console.log(response);
                         toast.fire(
                              'Success!',
                              'Payment method updated!',
                              'success'
                          );
                        resolve(); // Resolve the promise when settleTenant completes successfully
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error); // Reject the promise if there's an error
                    });
            });
        },
        deletePayment(id){
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
                  axios.delete('/api/payment/'+id).then(() => {
                  toast.fire(
                    'Deleted!',
                    'Payment has been deleted.',
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
          axios.get('api/userpermissions/' + id)
            .then((response) => {
              this.permissions = response.data.permissions;
              console.log(this.permissions)

              // Define the permission id you want to check for
              const requiredAddPermissionId = 6;
              const requiredEditPermissionId = 7;
              const requiredDeletePermissionId = 8;
              const requiredVacatePermissionId = 9;
              const requiredStatus = 1;

              // Check if the user has the required permissions
              const hasAddPermission = this.permissions.some(permission => 
                permission.permission_id === requiredAddPermissionId && permission.status === requiredStatus);

              const hasEditPermission = this.permissions.some(permission => 
                permission.permission_id === requiredEditPermissionId && permission.status === requiredStatus);

              const hasDeletePermission = this.permissions.some(permission => 
                permission.permission_id === requiredDeletePermissionId && permission.status === requiredStatus);

              const hasVacatePermission = this.permissions.some(permission => 
                permission.permission_id === requiredVacatePermissionId && permission.status === requiredStatus);

              if (hasAddPermission) {
                // User has the required permission, allow them to view things
                this.addTenantPermission = true;
                console.log(`User has permission: ${this.addTenantPermission}`);
              } else {
                // User does not have the required permission
                this.addTenantPermission = false;
                console.log('User does not have the required permission');
              }

              if (hasEditPermission) {
                // User has the required permission, allow them to view things
                this.editTenantPermission = true;
                console.log(`User has permission: ${this.editTenantPermission}`);
              } else {
                // User does not have the required permission
                this.editTenantPermission = false;
                console.log('User does not have the required permission');
              }

              if (hasDeletePermission) {
                // User has the required permission, allow them to view things
                this.deleteTenantPermission = true;
                console.log(`User has permission: ${this.deleteTenantPermission}`);
              } else {
                // User does not have the required permission
                this.deleteTenantPermission = false;
                console.log('User does not have the required permission');
              }

              if (hasVacatePermission) {
                // User has the required permission, allow them to view things
                this.vacateTenantPermission = true;
                console.log(`User has permission: ${this.vacateTenantPermission}`);
              } else {
                // User does not have the required permission
                this.vacateTenantPermission = false;
                console.log('User does not have the required permission');
              }

              })
              .catch(error => {
                console.error('Error fetching permissions:', error);
                this.vacateTenantPermission = false;
              });
        },
        loadLists() {
             axios.get('api/lists').then((response) => {

             this.payments = response.data.lists.payments;
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
        this.userId = this.user.id;
        this.getUserPermissions(this.userId);

      }
    }
    </script>
    
    
    