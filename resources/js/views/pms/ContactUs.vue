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
                      <h5 class="card-title">Contact Information<span>| Contact information for April Properties</span></h5>
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
                                  Add Contact Info
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
                            <th scope="col">Primary Phone</th>
                            <th scope="col">Secondary Phone</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Physical Address</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="contact in contacts" :key="contact.id">
                            <td>{{contact.phone ?? "N/A"}}</td>
                            <td>{{contact.phone_2 ?? "N/A"}}</td>
                            <td>{{contact.email ?? "N/A"}}</td>
                            <td>{{contact.address ?? "N/A"}}</td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a class="dropdown-item" @click="viewContact(contact)" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                                  <a @click="editContact(contact)" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                                  <a v-if="contact.id !== 2" @click="deleteContact(contact.id)" class="dropdown-item" href="#"><i class="ri-delete-bin-line mr-2"></i>Delete</a>
                                  </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <!--show total tenants-->
                        <div><strong>Contacts: {{contacts.length}}</strong></div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="viewContactModal" tabindex="-1" aria-labelledby="viewContactModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="viewContactModalLabel">View Contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p v-if="selectedContact">
                              <strong>Primary Phone:</strong> {{ selectedContact.phone }}
                            </p>
                            <p v-if="selectedContact">
                              <strong>Secondary Phone:</strong> {{ selectedContact.phone_2 }}
                            </p>
                            <p v-else>
                              <strong>Secondary Phone:</strong> N/A
                            </p>
                            <p v-if="selectedContact.email">
                              <strong>Email Address:</strong> {{ selectedContact.email }}
                            </p>
                            <p v-else>
                              
                            </p>
                            <p v-if="selectedContact.address">
                              <strong>Physical Address:</strong> {{ selectedContact.address }}
                            </p>
                            <p v-else>
                              
                            </p>

                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Add ContactModal -->
                    <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="addContactModalLabel">Create Contact</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <!-- Modal body content -->
                            <div class="modal-body">
                              <p>
                                <strong>Primary Phone:</strong>
                                <input type="text" name="phone" v-model="form.phone" class="form-control">
                                <div v-if="errors.phone" class="text-danger">{{ errors.phone }}</div>
                              </p> 
                              <p>
                                <strong>Secondary Phone:*</strong>
                                <input type="text" name="phone_2" v-model="form.phone_2" class="form-control">
                                <div v-if="errors.phone_2" class="text-danger">{{ errors.phone_2 }}</div>
                              </p>

                              <p>
                                <strong>Email Address:</strong>
                                <input type="text" name="email" v-model="form.email" class="form-control">
                                <div v-if="errors.email" class="text-danger">{{ errors.email }}</div>
                              </p>

                              <p>
                                <strong>Physical Address:</strong>
                                <input type="text" name="address" v-model="form.address" class="form-control">
                                <div v-if="errors.address" class="text-danger">{{ errors.address }}</div>
                              </p>

                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
                            <!-- Additional buttons or actions -->
                            <button type="button" @click="createContact" class="btn btn-primary" style="background-color: darkgreen; border-color: darkgreen;">Save</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!--Edit Contact Modal -->
                    <div class="modal fade" id="EditContactModal" tabindex="-1" aria-labelledby="EditContactModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="EditContactModalLabel">Edit Contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>#{{selectedContact.id}}</p>
                              <p>
                                <strong>Primary Phone:</strong>
                                <input type="text" name="phone" v-model="form.phone" class="form-control">
                                <div v-if="errors.phone" class="text-danger">{{ errors.phone }}</div>
                              </p> 
                              <p>
                                <strong>Secondary Phone:*</strong>
                                <input type="text" name="phone_2" v-model="form.phone_2" class="form-control">
                                <div v-if="errors.phone_2" class="text-danger">{{ errors.phone_2 }}</div>
                              </p>

                              <p>
                                <strong>Email Address:</strong>
                                <input type="text" name="email" v-model="form.email" class="form-control">
                                <div v-if="errors.email" class="text-danger">{{ errors.email }}</div>
                              </p>

                              <p>
                                <strong>Physical Address:</strong>
                                <input type="text" name="address" v-model="form.address" class="form-control">
                                <div v-if="errors.address" class="text-danger">{{ errors.address }}</div>
                              </p>           

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-primary" @click.prevent="confirmEditContact">Save changes</button>
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
          contacts: [],
          categories: [],
          user: [],
          addTenantPermission: '',
          editTenantPermission: '',
          deleteTenantPermission: '',
          vacateTenantPermission: '',
          selectedContact: {},

          form: {
            phone : '',
            phone_2: '',
            email: '',
            address: ''
          },
          errors: {
            phone : '',
            phone_2: '',
            email: '',
            address: ''
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
        viewContact(contact) {
          this.selectedContact = contact;

          const modal = new bootstrap.Modal(document.getElementById('viewContactModal'));
          modal.show();
        },
        openModal() {
          //reset form 
          this.form.phone_2 = '';
          this.form.phone = '';
          this.form.email = '';
          this.form.address = '';
          //reset error
          this.errors.phone_2 = '';
          this.errors.phone = '';
          this.errors.email = '';
          this.errors.address = '';
          const modal = new bootstrap.Modal(document.getElementById('addContactModal'));
          modal.show();
        },
        closeModal() {
          // $('#addPaymentModal').modal('hide'); // Hide the modal using jQuery
          const modal = bootstrap.Modal.getInstance(document.getElementById('addContactModal'));
          modal.hide();
        },
        createContact()
        {
          // Validate payment
          if (!this.form.phone) {
            this.errors.phone = 'Primary phone is required.';
            return;
          }

          // Validate email
          if (!this.form.email) {
            this.errors.email = 'Email address is required.';
            return;
          }

          console.log(this.form)
          axios.post("/api/contacts", this.form)
              .then(response => {
                this.successMessage = 'Contact created!';
                toast.fire(
                  'Success!',
                  'Contact created!',
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
                const modal = bootstrap.Modal.getInstance(document.getElementById('addContactModal'));
                modal.hide();

                // Reset form
                this.form.phone_2 = '';
                this.form.phone = '';
                this.form.email = '';
                this.form.address = '';
                this.loadLists();

              });

        },
        editContact(contact)
        {
          this.selectedContact = contact;
          this.form.phone = this.selectedContact.phone;
          this.form.phone_2 = this.selectedContact.phone_2;
          this.form.email = this.selectedContact.email;
          this.form.address = this.selectedContact.address;

          // Show the modal after fetching data
            const modal = new bootstrap.Modal(document.getElementById('EditContactModal'));
            modal.show();
        },
        async confirmEditContact() {
          if (this.selectedContact && this.selectedContact.id) {
            // Implement your logic to edit contact here
            console.log("Editing contact with contact ID:", this.selectedContact.id);
            await this.saveEditContact();

            // Close the modal after 
            const modal = bootstrap.Modal.getInstance(document.getElementById('EditContactModal'));
            modal.hide();
            this.loadLists()
          }
        },
        saveEditContact() {
            return new Promise((resolve, reject) => {
                let payload; // Define payload variable outside the if-else blocks

                  payload = {
                      phone: this.form.phone,
                      phone_2: this.form.phone_2,
                      email: this.form.email,
                      address: this.form.address,
                  };
               

                axios.put("/api/contact/" + this.selectedContact.id, payload)
                    .then(response => {
                        console.log(response);
                         toast.fire(
                              'Success!',
                              'Contact updated!',
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
        deleteContact(id){
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
                  axios.delete('/api/contact/'+id).then(() => {
                  toast.fire(
                    'Deleted!',
                    'Contact has been deleted.',
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

             this.contacts = response.data.lists.contacts;
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
    
    
    