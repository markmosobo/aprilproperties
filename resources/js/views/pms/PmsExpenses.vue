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
                      <h5 class="card-title">All Expenses <span>| Today</span></h5>
                      <p class="card-text">
                   
                      <router-link to="/add-pmsexpense" custom v-slot="{ href, navigate, isActive }">
                          <a
                            :href="href"
                            v-if="addExpensePermission"
                            :class="{ active: isActive }"
                            class="btn btn-sm btn-primary rounded-pill"
                            style="background-color: darkgreen; border-color: darkgreen;"
                            @click="navigate"
                          >
                            Add Expense
                          </a>
                      </router-link>
            
                      </p>
    
                      <table id="AllPropertiesTable" class="table table-borderless">
                        <thead>
                          <tr>
                            <th scope="col">Reference No.</th>
                            <th scope="col">Type</th>
                            <th scope="col">Amount(KES)</th>
                            <th scope="col">Expended To</th>
                            <th scope="col">Checked By</th>
                            <th scope="col">Checked On</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="expense in expenses" :key="expense.id">
                            <td>{{expense.ref_no}}</td>
                            <td>{{expense.payment_type}}</td>
                            <td>{{formatNumber(expense.amount_paid)}}</td>
                            <td>{{expense.paid_to}}</td>
                            <td>{{expense.user.first_name}} {{expense.user.last_name}}</td>
                            <td>{{format_date(expense.created_at)}}</td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <!-- <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>                                             -->
                                  <a v-if="expense.created_by == user.id" @click="navigateTo('/editexpense/'+expense.id )" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                                  <a class="dropdown-item" @click="generateInvoice(expense.id)" href="#"><i class="ri-printer-fill mr-2"></i>Download Invoice</a>
                                  <a v-if="editExpensePermission" @click="editExpense(expense)" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                                  <a v-if="deleteExpensePermission" @click="deleteExpense(expense.id)" class="dropdown-item" href="#"><i class="ri-delete-bin-line mr-2"></i>Delete</a>
                                  </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div><strong>Total Amount Paid: {{ formatNumber(calculateTotal()) }}</strong></div>

                    </div>

                    <!--Edit Expense Modal -->
                    <div class="modal fade" id="EditExpenseModal" tabindex="-1" aria-labelledby="EditExpenseModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="EditExpenseModalLabel">Edit Invoice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>#{{ref_no}}</p>
                            <p v-if="selectedExpense">
                              <div class="row">
                                <div class="col-sm-6">
                                  <strong>Property:</strong> 
                                  <select @change="getUnits" name="landlord" v-model="form.pms_property_id" class="form-select" id="">
                                    <option value="0" selected disabled>Select Property</option>
                                    <option v-for="property in properties" :value="property.id"
                                    :selected="property.id == form.pms_property_id" :key="property.id">{{ property.name}} </option>
         
                                 </select>
                                </div>
                                <div class="col-sm-6">
                                 <strong>Unit:</strong>
                                  <select :disabled="!form.pms_property_id" name="unit" v-model="form.pms_unit_id" class="form-select" id="">
                                      <option value="0" selected disabled>Select Unit</option>
                                      <option v-for="unit in propunits" :value="unit.id"
                                      :selected="unit.id == form.unit_id" :key="unit.id">{{ unit.unit_number}}</option>
           
                                   </select>
                                </div>
                              </div>   
                            </p>
                            <p v-if="selectedExpense">
                              <div class="row">
                                <div class="col-sm-6">
                                  <strong>Amount Paid:</strong> 
                                  <input
                                      type="number"
                                      placeholder="Amount Paid"
                                      id="title"
                                      name="title"
                                      v-model="form.amount_paid"
                                      class="form-control"
                                      required=""
                                  />
                                </div>
                                <div class="col-sm-6">
                                 <strong>Paid To:</strong>
                                 <input
                                      type="text"
                                      placeholder="Paid To"
                                      id="title"
                                      name="title"
                                      v-model="form.paid_to"
                                      class="form-control"
                                      required=""
                                  />
                                </div>
                              </div>   
                            </p>
                            <p v-if="selectedExpense">
                              <div class="row">
                                <div class="col-sm-12">
                                  <strong>Remarks:</strong> 
                                 <textarea placeholder="Briefly describe what was paid fore.g Slashing or Repair Works" name="payment_type" v-model="form.payment_type" class="form-control" />
                                </div>
                              </div>   
                            </p>

                            

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-primary" @click.prevent="confirmEditExpense">Save changes</button>
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
    import moment  from 'moment';
    import jsPDF from 'jspdf';

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
          expenses: [],
          properties: [],
          units: [],
          user: [],
          pmsexpense: [],
          selectedExpense: '',
          form: {
            pms_property_id: '',
            pms_unit_id: '',
            paid_to: '',
            amount_paid: '',
            payment_type: ''
          },
          loading: false,
          addExpensePermission: '',
          editExpensePermission: '',
          deleteExpensePermission: ''
        }
      },
      methods: {
        editExpense(expense)
        {
          this.selectedExpense = expense;
          this.ref_no = this.selectedExpense.ref_no;
          this.form.pms_property_id = this.selectedExpense.pms_property_id;
          this.form.pms_unit_id = this.selectedExpense.pms_unit_id;
          this.form.paid_to = this.selectedExpense.paid_to;
          this.form.amount_paid = this.selectedExpense.amount_paid;
          this.form.payment_type = this.selectedExpense.payment_type;

          // Show the modal after fetching data
            const modal = new bootstrap.Modal(document.getElementById('EditExpenseModal'));
            modal.show();
        },
        async confirmEditExpense() {
          if (this.selectedExpense && this.selectedExpense.id) {
            // Implement your logic to invoice the tenant here
            console.log("Editing expense ID:", this.selectedExpense.id);
            await this.saveEditExpense();

            // Close the modal after invoicing
            const modal = bootstrap.Modal.getInstance(document.getElementById('EditExpenseModal'));
            modal.hide();
            this.loadLists()
          }
        },
        saveEditExpense() {
            return new Promise((resolve, reject) => {
                this.loading = true;
                let payload; // Define payload variable outside the if-else blocks

                  payload = {
                      pms_property_id: this.form.pms_property_id,
                      pms_unit_id: this.form.pms_unit_id,
                      paid_to: this.form.paid_to,
                      amount_paid: this.form.amount_paid,
                      payment_type: this.form.payment_type,
                  };
               

                axios.put("/api/pmsexpense/" + this.selectedExpense.id, payload)
                    .then(response => {
                        console.log(response);
                        this.loading = false;
                         toast.fire(
                              'Success!',
                              'Expense updated!',
                              'success'
                          );
                        resolve(); // Resolve the promise when settleTenant completes successfully
                    })
                    .catch(error => {
                        this.loading = false;
                        console.log(error);
                        reject(error); // Reject the promise if there's an error
                    });
                    this.loadLists();
            });
        },
        async getUnits() {
         try {
           //const propunits = this.units.find(unit => unit.pms_property_id === this.form.pms_property_id);
           this.propunits = this.units.filter(item => item.pms_property_id === this.form.pms_property_id);

           console.log("amoit", this.propunits)
         } catch (error) {
           console.error(error);
         }
       },
        format_date(value){
          if(value){
            return moment(String(value)).format('MMM Do YYYY')
          }
        },
        formatNumber(value) {
          // Use the toLocaleString method to format the number with commas and decimal places
          return value.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });
        },
        calculateTotal() {
          // Function to calculate total amount paid
          this.paidTotal = this.expenses.reduce((total, expense) => total + (expense.amount_paid || 0), 0);
          console.log("mbichwa", this.paidTotal)
          return this.expenses.reduce((total, expense) => total + (expense.amount_paid || 0), 0);
        },
        navigateTo(location){
            this.$router.push(location)
        },
        generateInvoice(id) {
          //get expense
          axios.get('/api/pmsexpense/'+id).then((response) => {
              this.pmsexpense = response.data.pmsexpense
                        // Create a new instance of jsPDF
          const pdf = new jsPDF();
          var img = new Image();
          img.src = '/images/apex-logo.png';

          // pdf.addImage(img, 'PNG', 10, 10, 40, 40, { align: "center" });
          pdf.setFont("helvetica");
          pdf.setFontSize(20);
          pdf.text("Expense Invoice", 100, 20, { align: "center" });

          // Invoice Information
          pdf.setFontSize(12);
          pdf.text("Reference Number: "+this.pmsexpense.ref_no, 10, 40);
          pdf.text("Date: " + new Date(this.pmsexpense['created_at']).toLocaleDateString(), 10, 50);

          // Customer Information
          pdf.text("Expended To: "+ this.pmsexpense.paid_to, 10, 70);
          pdf.text("Checked By: "+this.pmsexpense.user.first_name + " "+ this.pmsexpense.user.last_name, 10, 80);
          pdf.text("Remarks: "+this.pmsexpense.payment_type+" by "+this.pmsexpense.paid_to, 10, 90);
          // pdf.text("Unit: "+this.pmsexpense.unit.unit_number, 10, 100);

          // Add a horizontal line
          pdf.line(10, 110, 200, 110);

          // Table Header
          // pdf.setFontType("bold");
          pdf.text("Property", 20, 120);
          pdf.text("Remarks", 80, 120);
          pdf.text("Cost", 160, 120);

          // Table Rows
          // pdf.setFontType("normal");
          pdf.text(this.pmsexpense.property.name+" - "+this.pmsexpense.unit.unit_number, 20, 130);
          pdf.text(this.pmsexpense.payment_type, 80, 130);
          pdf.text("KES "+this.pmsexpense.amount_paid.toFixed(2), 160, 130);


          // Total
          // pdf.setFontType("bold");
          pdf.text("Total: KES " + this.pmsexpense.amount_paid.toFixed(2), 160, 160);
          pdf.text("Balance: KES " + "0.00", 160, 170);
          pdf.setFontSize(10);
          pdf.text("Because you are worth it!", 100, 190, { align: "center" });
         
          // Add content to the PDF
          // pdf.text('Hello, this is a PDF generated with Vue.js!', 10, 10);
          img.onload = function() {
          // pdf.addImage(img, 'PNG', 10, 10, 40, 40);
          pdf.addImage(img, 'PNG', 10, 10, 20, 20);


          // Save the PDF
          pdf.save('invoice-pdf.pdf');
          };
              console.log("user", response)
          })

        },
        deleteExpense(id){
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
                  axios.delete('/api/pmsexpense/'+id).then(() => {
                  toast.fire(
                    'Deleted!',
                    'Expense has been deleted.',
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
              const requiredAddPermissionId = 13;
              const requiredEditPermissionId = 14;
              const requiredDeletePermissionId = 15;
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
                this.addExpensePermission = true;
                console.log(`User has permission: ${this.addExpensePermission}`);
              } else {
                // User does not have the required permission
                this.addExpensePermission = false;
                console.log('User does not have the required permission');
              }

              if (hasEditPermission) {
                // User has the required permission, allow them to view things
                this.editExpensePermission = true;
                console.log(`User has permission: ${this.editExpensePermission}`);
              } else {
                // User does not have the required permission
                this.editExpensePermission = false;
                console.log('User does not have the required permission');
              }

              if (hasDeletePermission) {
                // User has the required permission, allow them to view things
                this.deleteExpensePermission = true;
                console.log(`User has permission: ${this.deleteExpensePermission}`);
              } else {
                // User does not have the required permission
                this.deleteExpensePermission = false;
                console.log('User does not have the required permission');
              }
              })
              .catch(error => {
                console.error('Error fetching permissions:', error);
              });
        },
        loadLists() {
             axios.get('api/lists').then((response) => {

               this.expenses = response.data.lists.pmsexpenses;
               this.units = response.data.lists.units;
               this.properties = response.data.lists.pmsproperties;
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
    
    
    