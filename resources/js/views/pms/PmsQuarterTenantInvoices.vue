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
    
                        <li>
                            <router-link :to="`/pmstenantinvoices/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
                            <a
                                :href="href"
                                :class="{ active: isActive }"
                                class="dropdown-item"
                                @click="navigate"
                            >
                            This Month</a>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="`/pmslastmonthtenantinvoices/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
                            <a
                                :href="href"
                                :class="{ active: isActive }"
                                class="dropdown-item"
                                @click="navigate"
                            >
                            Last Month</a>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="`/pmslastninetytenantinvoices/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
                            <a
                                :href="href"
                                :class="{ active: isActive }"
                                class="dropdown-item"
                                @click="navigate"
                            >
                            Last 90 Days</a>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="`/pmsquartertenantinvoices/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
                            <a
                                :href="href"
                                :class="{ active: isActive }"
                                class="dropdown-item"
                                @click="navigate"
                            >
                            This Quarter</a>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="`/pmsyeartenantinvoices/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
                            <a
                                :href="href"
                                :class="{ active: isActive }"
                                class="dropdown-item"
                                @click="navigate"
                            >
                            This Year</a>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="`/pmslastyeartenantinvoices/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
                            <a
                                :href="href"
                                :class="{ active: isActive }"
                                class="dropdown-item"
                                @click="navigate"
                            >
                            Last Year</a>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="`/pmsalltenantinvoices/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
                            <a
                                :href="href"
                                :class="{ active: isActive }"
                                class="dropdown-item"
                                @click="navigate"
                            >
                            All Time</a>
                            </router-link>
                        </li>

                      </ul>
                    </div>
    
                    <div class="card-body pb-0">
                      <h5 class="card-title">{{tenantName}}'s Invoices <span>| This Quarter</span></h5>
                      <p class="card-text">
                   
                          <!-- <button v-if="statements.length !== 0" @click="generatePDF">Generate PDF</button> -->
                          <div class="row">
                        <div class="col d-flex">
                          <button class="me-2" v-if="statements.length !== 0" @click="exportToExcel">Export</button>
                          <button v-if="statements.length !== 0" @click="printInvoice" class="me-2">Print Invoice</button>
                          <button v-if="statements.length !== 0" @click="generatePDF">Generate Rent Statement</button>
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
    
                      <table id="AllStatementsTable" class="table table-borderless">
                        <thead>
                          <tr>
                            <th scope="col">Invoice</th>
                            <th scope="col">Property</th>                            
                            <th scope="col">Detail</th>
                            <th scope="col">Due</th>
                            <th scope="col">Paid</th>
                            <th scope="col">Bal</th>
                            <th scope="col">Date Paid</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="statement in statements" :key="statement.id">
                            <td>{{statement.ref_no}}</td>
                            <td>{{statement.property.name}}</td>                            
                            <td>{{statement.details}}</td>
                            <td>{{formatNumber(statement.total)}}</td>
                            <td>{{formatNumber(statement.paid)}}</td>
                            <td>{{formatNumber(statement.balance)}}</td>
                            <td>{{format_date(statement.paid_at ?? "N/A")}}</td>
                            <td>
                              <span v-if="statement.status == 0 && statement.water_bill == null" class="badge bg-info text-dark"><i class="bi bi-clipboard2-x"></i> Not Invoiced</span>
                              <span v-else-if="statement.status == 1" class="badge bg-success"><i class="bi bi-clipboard2-check"></i> Settled</span>
                              <span v-else-if="statement.status == 0 && statement.water_bill !== null" class="badge bg-warning text-dark"><i class="bi bi-clipboard2-x"></i> Not Settled</span>
                              <span v-else class="badge bg-dark text-light"><i class="bi bi-exclamation-triangle me-1"></i> Vacant</span>
                            </td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a @click="navigateTo('/viewinvoice/'+statement.statement_id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a> 
                                  <a @click="print(statement)" class="dropdown-item" href="#"><i class="ri-printer-line mr-2"></i>Print</a>
                                  <a v-if="statement.status == 0 && statement.water_bill == null" @click="invoiceTenant(statement)" class="dropdown-item" href="#"><i class="ri-bill-line mr-2"></i>Invoice</a>
                                  <a v-if="statement.status == 0 && statement.water_bill !== null" @click="settleTenant(statement)" class="dropdown-item" href="#"><i class="ri-check-fill mr-2"></i>Settle</a>                                                                             
                                  <!-- <a v-if="statement.status == 0" @click="settleTenant(statement.statement_id, statement.pms_tenant_id)" class="dropdown-item" href="#"><i class="ri-check-fill mr-2"></i>Settle</a> -->
                                  </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
<!--                       <div><strong>Total: 
                        Due: {{ formatNumber(calculateTotal('total')) }},
                        Paid: {{ formatNumber(calculateTotal('paid')) }},
                        Bal: {{ formatNumber(calculateTotal('balance')) }}
                      </strong>
                      </div>   -->  
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="invoiceTenantModal" tabindex="-1" aria-labelledby="invoiceTenantModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="invoiceTenantModalLabel">Invoice Tenant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>#{{selectedStatement.ref_no}}</p>
                            <p v-if="selectedStatement && selectedStatement.tenant">
                              <strong>Tenant Name:</strong> {{ selectedStatement.tenant.first_name }} {{ selectedStatement.tenant.last_name }}
                            </p>
                            <p v-else>
                              <strong>Tenant Name:</strong> N/A
                            </p>
                            <p v-if="selectedStatement">
                              <strong>Amount Due:</strong> {{ formatNumber(selectedStatement.total) }}
                            </p>
                            <p v-else>
                              <strong>Amount Due:</strong> N/A
                            </p>
                            <p>
                              <strong>Water Bill:</strong>
                              <input type="number" name="water_bill" v-model="form.water_bill" class="form-control">
                              <div v-if="errors.water_bill" class="text-danger">{{ errors.water_bill }}</div>
                            </p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-primary" @click="confirmInvoiceTenant">
                              <span v-if="loading">
                                <i class="fa fa-spinner fa-spin"></i> Invoicing...
                              </span>
                              <span v-else>
                                Invoice Tenant
                              </span>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="settleTenantModal" tabindex="-1" aria-labelledby="settleTenantModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="settleTenantModalLabel">Settle Invoice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>#{{selectedStatement.ref_no}}</p>
                            <p v-if="selectedStatement && selectedStatement.tenant">
                              <strong>Tenant Name:</strong> {{ selectedStatement.tenant.first_name }} {{ selectedStatement.tenant.last_name }}
                            </p>
                            <p v-else>
                              <strong>Tenant Name:</strong> N/A
                            </p>
                            <p v-if="selectedStatement">
                              <div class="row">
                                <div class="col-sm-6">
                                 <strong>Amount Due:</strong> {{ formatNumber(selectedStatement.total) }}
                                </div>
                                <div class="col-sm-6">
                                 <strong>Amount Paid:</strong> {{ formatNumber(selectedStatement.paid) }}
                                </div>
                              </div>   
                            </p>
                            <p v-else>
                              <strong>Amount Due:</strong> N/A
                            </p>
                            <label v-if="lastmonthBalance < 0" for="validationCustom04" class="form-label"
                                ><span style="color: green;">Overpayment: <strong>KES {{lastmonthstatement.balance}}</strong></span>              
                            </label>

                            <label v-if="lastmonthstatement.balance > 0" for="validationCustom04" class="form-label"
                              ><span style="color: red;">Last Month Arrears: <strong>KES {{lastmonthstatement.balance}}</strong></span></label
                            >
                            <p>
                              <div class="row">
                                <div class="col-sm-6">
                                  <strong>Payment Method:</strong>
                                  <select name="category" v-model="form.payment_method" class="form-select" id="payment-method-1">
                                    <option value="0" disabled>Select Payment</option>
                                    <option value="Mpesa" selected>MPESA</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank Transfer</option>
                                  </select>
                                  <div v-if="errors.payment_method" class="text-danger">{{ errors.payment_method }}</div>
                                </div>
                                <div v-if="form.payment_method === 'Mpesa'" class="col-sm-6">
                                  <strong>MPESA Code:</strong>
                                  <input type="text" name="mpesa_code" v-model="form.mpesa_code" class="form-control">
                                  <div v-if="errors.mpesa_code" class="text-danger">{{ errors.mpesa_code }}</div>
                                </div>
                              </div>
                            </p>
                            <p>
                              <div class="row">
                                <div class="col-sm-6">
                                  <strong>Amount Paid:</strong>
                                  <input type="number" :disabled="!form.payment_method" name="cash" v-model="form.cash" class="form-control">
                                  <div v-if="errors.cash" class="text-danger">{{ errors.cash }}</div>
                                </div>
                                <div class="col-sm-6">
                                  <strong>Balance</strong>
                                  <h6 v-if="lastmonthBalance < 0">{{payableOverAmount}}</h6>
                                  <h6 v-else>{{payableAmount}}</h6>
                                </div>
                              </div>    
                            </p>

                            <p>
                              <button v-if="lastmonthBalance < 0" @click.prevent="applyOverPayment" :disabled="!form.cash">Apply Overpayment</button>
                            </p>
                            

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-primary" @click.prevent="confirmSettleTenant">Settle Tenant</button>
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
    import moment from 'moment';
    import jsPDF from 'jspdf';
    import * as XLSX from 'xlsx';
    import aprilLogo from '@/assets/img/apex-logo.png';

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
          tenant: [],
          statements: [],
          user: [],
          tenantId: this.$route.params.id,
          logoBase64: '',
          tenantName: '',
          tenantUnit: '',
          tenantProperty: '',
          paymentMethod: '',
          accountNo: '',
          paybillNo: '',
          selectedStatement: {}, // Initialize as an empty object
          property: '',
          name: '',
          tenant: '',
          phoneNumber: '',
          unitNumber: '',
          refNo: '',
          details: '',
          date: '',
          invoiceDate: '',
          payDate: '',
          status: '',
          paid: '',
          balance: '',
          total: '',
          waterBill: '',
          isAmountValid: true,
          lastMonth: '',
          lastmonthstatement: [],
          lastmonthBalance: '',
          overPayment: false,
          payMethod: '',
          form: {
            water_bill : '',
            payment_method: '',
            cash: '',
            mpesa_code: '',
            balance: '',
            amountPaid: '',
            balAmount: ''
          },
          errors: {
            water_bill: '',
            cash: '',
            mpesa_code: ''
          },
          loading: false,
        }
      },
      methods: {
        getTenant()
        {
          axios.get('/api/pmstenant/'+ this.$route.params.id).then((response) => {
            this.tenant = response.data.tenant;
            this.fName = this.tenant.first_name;
            this.lName = this.tenant.last_name;
            this.tenantName = this.fName + " " + this.lName;
            this.tenantProperty = this.tenant.property.name;
            this.tenantPropertyId = this.tenant.property.id;
            this.getProperty(this.tenantPropertyId);
            this.tenantUnit = this.tenant.unit.unit_number;
            this.tenantUnitType = this.tenant.unit.type;
            console.log("dat", this.tenant)
          }).catch(() => {
              console.log('error')
          })
        },
        navigateTo(location){
            this.$router.push(location)
        },
        getUnit(unitNumber) {
            axios.get('/api/pmsunit/' + parseInt(unitNumber))
                .then((response) => {
                  this.unit = response.data.unit;
                  this.unitName = this.unit.unit_number;
                  this.unitRent = this.unit.monthly_rent;
                  this.unitSecurityFee = this.unit.security_fee;
                  this.unitGarbageFee = this.unit.garbage_fee;
                  this.unitType = this.unit.type;
                    console.log("unit", this.unit);
                    // Further processing of the response data if needed
                })
                .catch((error) => {
                    console.error("Error fetching unit:", error);
                });
        },
        getCurrentTimestamp() {
          const now = new Date();
          const year = now.getFullYear();
          const month = String(now.getMonth() + 1).padStart(2, '0');
          const day = String(now.getDate()).padStart(2, '0');
          const hours = String(now.getHours()).padStart(2, '0');
          const minutes = String(now.getMinutes()).padStart(2, '0');
          const seconds = String(now.getSeconds()).padStart(2, '0');

          return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        },
        async settleTenant(statement) {
          try {
            this.selectedStatement = statement;
            this.status = this.selectedStatement.status;
            this.paid = this.selectedStatement.paid;
            this.balance = this.selectedStatement.balance;
            this.total = this.selectedStatement.total;
            this.unitNumber = this.selectedStatement.pms_unit_id;
            this.getUnit(this.unitNumber);
            this.refNo = this.selectedStatement.ref_no;
            this.firstName = this.selectedStatement.tenant.first_name;
            this.lastName = this.selectedStatement.tenant.last_name;
            this.tenant = this.firstName + " " + this.lastName;
            this.date = this.selectedStatement.created_at;
            this.waterBillAmount = this.selectedStatement.water_bill;

            // Fetch last month's statement asynchronously
            await this.checkLastMonthStatement();

            console.log(this.selectedStatement);

            this.form.cash = ''; // Reset the form field
            this.errors.cash = ''; // Reset the error message

            // Show the modal after fetching data
            const modal = new bootstrap.Modal(document.getElementById('settleTenantModal'));
            modal.show();
          } catch (error) {
            console.error("Error settling tenant:", error);
          }
        },
        async checkLastMonthStatement() {
          try {
            const response = await axios.get('/api/pmslastmonthtenantstatements/' + this.selectedStatement.pms_tenant_id);
            if (response.data?.pmslastmonthtenantstatements?.length > 0) {
              this.lastmonthstatement = response.data.pmslastmonthtenantstatements[0];
              this.lastmonthBalance = this.lastmonthstatement.balance;
              console.log("OverPayment", this.lastmonthstatement);
            } else {
              console.log("No last month statement found for the tenant.");
            }
          } catch (error) {
            console.error("Error fetching last month tenant statements:", error);
            throw error; // Propagate the error upwards
          }
        },
        async confirmSettleTenant() {
           // Validate amount
          if (!this.form.cash) {
            this.errors.cash = 'Amount paid is required.';
            return;
          }
          if (this.selectedStatement && this.selectedStatement.id) {
            // Implement your logic to invoice the tenant here
            console.log("Settling tenant with statement ID:", this.selectedStatement.id);
            await this.settleInvoice();

            // Open a new window for printing
            const printWindow = window.open("", "_blank");

            // Build the content for printing
            const receiptContent = this.buildReceiptContent();

            // Write the content to the new window
            printWindow.document.write(receiptContent);

            // Close the document stream
            printWindow.document.close();

            // Trigger the print dialog
            printWindow.print();
            toast.fire(
                'Success!',
                'Invoice updated!',
                'success'
            );

            // Close the modal after invoicing
            const modal = bootstrap.Modal.getInstance(document.getElementById('settleTenantModal'));
            modal.hide();
            //reset form
            this.form.cash = '';
            this.form.payment_method = 'Mpesa';
            this.getTenantStatements()
          }
        },
        invoiceTenant(statement) {
          this.selectedStatement = statement;
          this.form.water_bill = ''; // Reset the form field
          this.errors.water_bill = ''; // Reset the error message
          const modal = new bootstrap.Modal(document.getElementById('invoiceTenantModal'));
          modal.show();
        },
        confirmInvoiceTenant() {
          // Validate water_bill
          if (!this.form.water_bill) {
            this.errors.water_bill = 'Water bill is required.';
            return;
          }

          if (this.selectedStatement && this.selectedStatement.id) {
            // Show loading spinner
            this.loading = true;
            this.successMessage = '';

            // Implement your logic to invoice the tenant here
            console.log("Invoicing tenant with statement ID:", this.selectedStatement.id);
            axios.put("/api/pmsinvoicestatement/" + this.selectedStatement.id, this.form)
              .then(response => {
                console.log(response);
                this.successMessage = 'Tenant invoiced!';
                toast.fire(
                  'Success!',
                  'Tenant invoiced!',
                  'success'
                );
              })
              .catch(error => {
                console.log(error);
                // Handle the error appropriately
                toast.fire(
                  'Error!',
                  'An error occurred while invoicing the tenant.',
                  'error'
                );
              })
              .finally(() => {
                // Hide loading spinner
                this.loading = false;

                // Close the modal after invoicing
                const modal = bootstrap.Modal.getInstance(document.getElementById('invoiceTenantModal'));
                modal.hide();

                // Reset form
                this.form.water_bill = '';
                this.form.cash = '';
                this.getTenantStatements();
              });
          }
        },

        formatNumber(value) {
            // Check if the value is not a number
            if (isNaN(value)) {
                return value; // Return as it is
            }
            
            // Convert the value to a string
            let stringValue = value.toString();

            // Split the string into integer and decimal parts
            let parts = stringValue.split('.');

            // Format the integer part with commas
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            // If there's a decimal part, limit it to 2 decimal places
            if (parts.length > 1) {
                parts[1] = parts[1].substring(0, 2);
            } else {
                parts.push('00'); // If no decimal part exists, append '00'
            }

            // Join the parts back together with a decimal point
            return parts.join('.');
        },
        format_date(value){
          if(value){
            return moment(String(value)).format('DD/MM/YYYY')
          }
        }, 
        formatMonth(dateString) {
          // Parse the date string using Moment.js and format it
           return moment(dateString).format('MMM YYYY');
        }, 
         calculateTotalAmountPaid() {
        if (!this.expenses || this.expenses.length === 0) {
              return 0; // If expenses data is empty or undefined, return 0
            }

            // Use reduce to sum up the amount_paid property for all expenses
            return this.expenses.reduce((total, expense) => total + expense.amount_paid, 0);
        },
        calculateTotal(tenant) {
          // Function to calculate total for Total, Paid, and Bal columns

          return this.statements.reduce((total, statement) => total + (statement[tenant] || 0), 0);
        }, 
         getCurrentTime() {
          const now = new Date();
          const hours = String(now.getHours()).padStart(2, '0');
          const minutes = String(now.getMinutes()).padStart(2, '0');
          const seconds = String(now.getSeconds()).padStart(2, '0');
          return `${hours}:${minutes}:${seconds}`;
        },
        updateTime() {
          this.currentTime = this.getCurrentTime();
        },
        getCurrentMonth() {
          const now = new Date();
          const options = { month: 'short', year: 'numeric' }; // 'short' for abbreviated month name, 'numeric' for year
          return now.toLocaleDateString('en-US', options);
        },  
        setLastMonth() {
          const date = new Date();
          date.setMonth(date.getMonth() - 1); // Get last month

          const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
          ];
          const month = monthNames[date.getMonth()];
          const year = date.getFullYear();

          this.lastMonth = `${month} ${year}`;
        },
        getProperty()
        {
            axios.get('/api/pmsproperty/'+this.tenantPropertyId).then((response) => {
                this.property = response.data.property
                this.accountNo = response.data.property.account_number
                this.paybillNo = response.data.property.paybill_number
                console.log("property", response)
            })
        },   
        getTenantStatements() {
             axios.get('/api/pmstenantinvoices/'+this.$route.params.id).then((response) => {
             this.statements = response.data.pmsquartertenantinvoices;
             if(this.totalDue == this.totalPaid) {
               this.paymentMethod = 'SETTLED'; 
             } 
             else{
                this.paymentMethod = 'NOT SETTLED'
             }

             console.log("invoices", response)
             setTimeout(() => {
                  $("#AllStatementsTable").DataTable();
              }, 10);
    
             });
        },
        getCurrentDate() {
          const now = new Date();
          const day = String(now.getDate()).padStart(2, '0');
          const month = String(now.getMonth() + 1).padStart(2, '0'); // January is 0, so we add 1
          const year = now.getFullYear();
          return `${day}/${month}/${year}`;
        },
        loadLogo() {
          fetch(aprilLogo)
            .then(response => response.blob())
            .then(blob => {
              const reader = new FileReader();
              reader.readAsDataURL(blob);
              reader.onloadend = () => {
                this.logoBase64 = reader.result;
                // console.log(this.logoBase64)
              };
            })
            .catch(error => {
              console.error('Error converting image to base64:', error);
            });
        },
        printInvoice(){
            // Open a new window for printing
            const printWindow = window.open("", "_blank");

            // Build the content for printing
            const invoiceContent = this.buildInvoiceContent();

            // Write the content to the new window
            printWindow.document.write(invoiceContent);

            // Close the document stream
            printWindow.document.close();

            // Trigger the print dialog
            printWindow.print();
        },
        buildInvoiceContent() {
          // Determine whether to include the row
          const showExpensesDeductionRow = this.expenses !== 0;
          const logoBase64 = this.logoBase64;
          const watermarkText = this.paymentMethod;
          // Build the HTML content for the receipt
          const receiptHTML = `
            <!DOCTYPE html>
            <html lang="en">
            <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Invoice Of Payment</title>
              <style>
                body {
                  font-family: Arial, sans-serif;
                  margin: 0;
                  padding: 0;
                  background-color: #f5f5f5;
                }
                .receipt {
                  max-width: 600px;
                  margin: 20px auto;
                  padding: 20px;
                  background-color: #fff;
                  border: 2px solid #ccc;
                  display: flex;
                  flex-direction: column;
                }
                 .watermark {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%) rotate(-45deg);
                    font-size: 80px;
                    color: rgba(0, 0, 0, 0.1); /* Adjust the transparency as needed */
                    white-space: nowrap;
                    z-index: 0;
                    pointer-events: none; /* Prevents watermark from interfering with other elements */
                  }
                .receipt-header {
                  display: flex;
                  justify-content: space-between;
                  align-items: center;
                  margin-bottom: 50px;
                }
                .company-info {
                  text-align: left;
                }
                .company-info img {
                  max-width: 150px;
                  height: auto;
                }
                .receipt-info {
                  margin-bottom: 50px;
                }
                .receipt-info p {
                  margin: 5px 0;
                  color: #555;
                }
                 .additional-info {
                  margin-bottom: 30px;
                  font-size: 16px;
                  color: #333333;
                }
                .additional-info p {
                  margin: 8px 0;
                }
                .payment-info {
                  margin-bottom: 30px;
                  font-size: 16px;
                  color: #333333;
                  text-align: center;
                }
                .payment-info p {
                  margin: 8px 0;
                }
                .receipt-table {
                  width: 100%;
                  border-collapse: collapse;
                  margin-bottom: 50px;
                }
                .receipt-table th, .receipt-table td {
                  padding: 8px;
                  border-bottom: 1px solid #ccc;
                }
                .receipt-table th {
                  text-align: left;
                  background-color: #f2f2f2;
                  color: #333;
                }
                .receipt-table td {
                  text-align: left;
                  color: #666;
                }
                .receipt-footer {
                  text-align: center;
                  margin-top: auto;
                }
                .receipt-footer p {
                  margin: 5px 0;
                  color: #777;
                }
              </style>
            </head>
            <body>
            <div class="watermark">${watermarkText}</div>
              <div class="receipt">
                <div class="receipt-header">
                  <div class="company-logo">
                    <img src="${logoBase64}" alt="Company Logo" style="max-width: 150px; height: auto;">
                  </div>
                  <div class="company-info">
                    <p>Kakamega-Webuye Rd, ACK Building</p>
                    <p>Phone: (0720) 020-401 </p>
                    <p> Email: propertapril@gmail.com</p>
                    <p> Website: www.aprilproperties.co.ke</p>
                  </div>
                </div>
                <div class="receipt-info">
                  <p><strong>Invoice for:</strong>This Quarter</p>
                  <p><strong>Printed On: </strong>  ${new Date().toLocaleString()}</p>
                  
                </div>
                <div class="additional-info">
                  <p><strong>Invoiced To:</strong></p>
                  <p><strong></strong> ${this.tenantName}</p>
                  <p><strong></strong> ${this.tenantProperty} - ${this.tenantUnit}</p>
                </div>
                <table class="receipt-table">
                  <thead>
                    <tr>
                      <th>Description</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Total Rent Due (Incl. Water Bill)</td>
                      <td>KES ${this.formatNumber(this.totalDue)}</td>
                    </tr>
                    <tr>
                      <td>Total Amount Paid</td>
                      <td>KES ${this.formatNumber(this.totalPaid)}</td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Total Balance:</th>
                      <td>KES ${this.formatNumber(this.totalBalance)}</td>
                    </tr>
                  </tfoot>
                </table>
                <div class="payment-info">
                  <p><strong>Payment Options:</strong></p>
                  <p>Mobile Money: Paybill - ${this.paybillNo ?? 'N/A'} Account Number - ${this.accountNo ?? 'N/A'}</p>
                </div>
                <div class="receipt-footer">
                  <p>Generated on ${new Date().toLocaleString()}</p>
                </div>
              </div>
            </body>
            </html>
          `;

          return receiptHTML;
        },
        settleInvoice() {
            return new Promise((resolve, reject) => {
                let payload; // Define payload variable outside the if-else blocks
                this.paid_at = this.getCurrentTimestamp();

                if (this.lastmonthBalance >= 0) {
                    payload = {
                        mpesa_code: this.form.mpesa_code,
                        payment_method: this.form.payment_method,
                        paid: this.paid + this.form.cash,
                        balance: this.payableAmount,
                        paid_at: this.paid_at
                    };
                } else {
                    payload = {
                        mpesa_code: this.form.mpesa_code,
                        payment_method: this.form.payment_method,
                        paid: this.paid,
                        balance: this.payableOverAmount,
                        paid_at: this.paid_at
                    };
                }

                if (this.lastmonthBalance < 0) {
                    this.updateLastMonthStatement();
                }

                axios.put("/api/pmssettlestatement/" + this.selectedStatement.id, payload)
                    .then(response => {
                        console.log(response);
                        this.statement = response.data.statement;
                        this.amountPaid = this.statement.paid;
                        this.balAmount = this.statement.balance;
                        // self.step = 1;
                        // toast.fire(
                        //     'Success!',
                        //     'Invoice updated!',
                        //     'success'
                        // );
                        resolve(); // Resolve the promise when settleTenant completes successfully
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error); // Reject the promise if there's an error
                    });
            });
        },
        print(statement) {
            console.log("merc",statement);
            this.name = statement.property.name;
            this.firstName = statement.tenant.first_name;
            this.lastName = statement.tenant.last_name;
            this.tenant = this.firstName + " " + this.lastName;
            this.phoneNumber = statement.tenant.phone_number;
            this.unitNumber = statement.tenant.pms_unit_id;
            this.tenantId = statement.pms_tenant_id;
            // this.getUnit(this.unitNumber);
            this.refNo = statement.ref_no;
            this.details = statement.details;
            this.date = statement.created_at;
            this.status = statement.status;
            this.paid = statement.paid;
            this.balance = statement.balance;
            this.invoiceDate = statement.updated_at;
            this.payDate = statement.paid_at;
            this.total = statement.total;
            this.payment = statement.payment_method;
            this.statementId = statement.id;
            this.waterBill = statement.water_bill;
            //unit info
            this.unitName = statement.unit.unit_number;
            this.unitRent = statement.unit.monthly_rent;
            this.unitSecurityFee = statement.unit.security_fee;
            this.unitGarbageFee = statement.unit.garbage_fee;
            this.unitType = statement.unit.type;

            // Open a new window for printing
            const printWindow = window.open("", "_blank");

            // Build the content for printing
            const receiptContent = this.buildPrintContent();

            // Write the content to the new window
            printWindow.document.write(receiptContent);

            // Close the document stream
            printWindow.document.close();

            // Trigger the print dialog
            printWindow.print();
        },
        buildPrintContent() {
          // Determine whether to include the row
          const showExpensesDeductionRow = this.expenses !== 0;
          const logoBase64 = this.logoBase64;
          const watermarkText = this.paymentMethod;
          // Build the HTML content for the receipt
          const receiptHTML = `
            <!DOCTYPE html>
            <html lang="en">
            <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Invoice Of Payment - ${this.refNo}</title>
              <style>
                body {
                  font-family: Arial, sans-serif;
                  margin: 0;
                  padding: 0;
                  background-color: #f5f5f5;
                }
                .receipt {
                  max-width: 600px;
                  margin: 20px auto;
                  padding: 20px;
                  background-color: #fff;
                  border: 2px solid #ccc;
                  display: flex;
                  flex-direction: column;
                }
                 .watermark {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%) rotate(-45deg);
                    font-size: 80px;
                    color: rgba(0, 0, 0, 0.1); /* Adjust the transparency as needed */
                    white-space: nowrap;
                    z-index: 0;
                    pointer-events: none; /* Prevents watermark from interfering with other elements */
                  }
                .receipt-header {
                  display: flex;
                  justify-content: space-between;
                  align-items: center;
                  margin-bottom: 50px;
                }
                .company-info {
                  text-align: left;
                }
                .company-info img {
                  max-width: 150px;
                  height: auto;
                }
                .receipt-info {
                  margin-bottom: 50px;
                }
                .receipt-info p {
                  margin: 5px 0;
                  color: #555;
                }
                 .additional-info {
                  margin-bottom: 30px;
                  font-size: 16px;
                  color: #333333;
                }
                .additional-info p {
                  margin: 8px 0;
                }
                .payment-info {
                  margin-bottom: 30px;
                  font-size: 16px;
                  color: #333333;
                  text-align: center;
                }
                .payment-info p {
                  margin: 8px 0;
                }
                .receipt-table {
                  width: 100%;
                  border-collapse: collapse;
                  margin-bottom: 50px;
                }
                .receipt-table th, .receipt-table td {
                  padding: 8px;
                  border-bottom: 1px solid #ccc;
                }
                .receipt-table th {
                  text-align: left;
                  background-color: #f2f2f2;
                  color: #333;
                }
                .receipt-table td {
                  text-align: left;
                  color: #666;
                }
                .receipt-footer {
                  text-align: center;
                  margin-top: auto;
                }
                .receipt-footer p {
                  margin: 5px 0;
                  color: #777;
                }
              </style>
            </head>
            <body>
            <div class="watermark">${watermarkText}</div>
              <div class="receipt">
                <div class="receipt-header">
                  <div class="company-logo">
                    <img src="${logoBase64}" alt="Company Logo" style="max-width: 150px; height: auto;">
                  </div>
                  <div class="company-info">
                    <p>Kakamega-Webuye Rd, ACK Building</p>
                    <p>Phone: (0720) 020-401 </p>
                    <p> Email: propertapril@gmail.com</p>
                    <p> Website: www.aprilproperties.co.ke</p>
                  </div>
                </div>
                <div class="receipt-info">
                  <p><strong>#${this.refNo}</strong></p>
                  <p><strong>Invoice Date:</strong> ${this.format_date(this.invoiceDate ?? 'N/A')}</p>
                  <p><strong>Payment Date:</strong>  ${this.format_date(this.payDate ?? 'N/A')}</p>
                  <p><strong>Payment Mode:</strong> ${this.payment ?? 'N/A'}</p>
                  
                </div>
                <div class="additional-info">
                    <p><strong>Invoiced To</strong></p>
                    <p><strong></strong> ${this.tenant}</p>
                    <p><strong></strong> ${this.name} - ${this.unitName}</p>
                    <p><strong></strong> ${this.details}</p>
                </div>
                <table class="receipt-table">
                  <thead>
                    <tr>
                      <th>Description</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Total Rent Due (Incl. Water Bill)</td>
                      <td>KES ${this.formatNumber(this.total)}</td>
                    </tr>
                    <tr>
                      <td>Total Amount Paid</td>
                      <td>KES ${this.formatNumber(this.paid)}</td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Total Balance:</th>
                      <td>KES ${this.formatNumber(this.balance)}</td>
                    </tr>
                  </tfoot>
                </table>
                <div class="payment-info">
                  <p><strong>Payment Options:</strong></p>
                  <p>Mobile Money: Paybill - ${this.paybillNo} Account Number - ${this.accountNo}</p>
                </div>
                <div class="receipt-footer">
                  <p>Generated on ${new Date().toLocaleString()}</p>
                </div>
              </div>
            </body>
            </html>
          `;

          return receiptHTML;
        },
        printReceipt(statement) {
          this.submit().then(() => {
              // Continue with the rest of the function after submit completes
              // this.$router.push('/statements');
              this.$router.go(-1);

              // Open a new window for printing
              const printWindow = window.open("", "_blank");

              // Build the content for printing
              const receiptContent = this.buildReceiptContent();

              // Write the content to the new window
              printWindow.document.write(receiptContent);

              // Close the document stream
              printWindow.document.close();

              // Trigger the print dialog
              printWindow.print();
              toast.fire(
                  'Success!',
                  'Invoice updated!',
                  'success'
              );
          }).catch(error => {
              console.error("Error during submission:", error);
              // Handle error if needed
          });
        },

        buildReceiptContent(refNo) {
         // Determine whether to include the row
          const showGarbageFeeRow = this.unitGarbageFee !== 0;
          const showSecurityFeeRow = this.unitSecurityFee !== 0;
          // Build the HTML content for the receipt
          const receiptHTML = `
          <!DOCTYPE html>
          <html lang="en">
          <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Receipt Of Payment</title>
            <style>
              body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f5f5f5;
              }
              .receipt {
                max-width: 600px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                border: 2px solid #ccc;
                border-radius: 10px;
              }
              .receipt-header {
                text-align: center;
                margin-bottom: 20px;
              }
              .receipt-header h1 {
                margin: 10px 0;
                color: #333;
              }
              .receipt-info {
                margin-bottom: 20px;
              }
              .receipt-info p {
                margin: 5px 0;
                color: #555;
              }
              .receipt-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
              }
              .receipt-table th, .receipt-table td {
                padding: 8px;
                border-bottom: 1px solid #ccc;
              }
              .receipt-table th {
                text-align: left;
                background-color: #f2f2f2;
                color: #333;
              }
              .receipt-table td {
                text-align: left;
                color: #666;
              }
              .receipt-footer {
                text-align: center;
              }
              .receipt-footer p {
                margin: 5px 0;
                color: #777;
              }
            </style>
          </head>
          <body>
            <img src="@/assets/img/apex-logo.png" alt="Company Logo" style="display: block; margin: 0 auto; max-width: 100%;">

            <div class="receipt">
              <div class="receipt-header">
                <h1>April Properties</h1>
                <p>Kakamega-Webuye Rd, ACK Building</p>
                <p>Phone: (0720) 020-401 | Email: propertapril@gmail.com</p>
              </div>
              <div class="receipt-info">
                <p><strong>Invoice Number:</strong> ${this.refNo}</p>
                <p><strong>Receipt Date:</strong> ${new Date().toLocaleString()}</p>
                <p><strong>Rent Month:</strong> ${this.formatMonth(this.date)}</p>
                <p><strong>Tenant:</strong> ${this.tenant}</p>
                <p><strong>Property:</strong> ${this.name} - ${this.unitName}</p>
                <p><strong>Payment Mode:</strong> ${this.form.payment_method}</p>
              </div>
              <table class="receipt-table">
                <thead>
                  <tr>
                    <th>Description</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Rent Payment</td>
                    <td>KES ${this.formatNumber(this.unitRent)}</td>
                  </tr>
                  <tr>
                    <td>Water Bill</td>
                    <td>KES ${this.formatNumber(this.waterBillAmount)}</td>
                  </tr>
                  <!-- Conditionally include garbage collection fee row -->
                  ${showGarbageFeeRow ? `
                  <tr>
                    <td>Garbage Collection Fee</td>
                    <td>KES ${this.formatNumber(this.unitGarbageFee)}</td>
                  </tr>
                  ` : ''}
                  </tr>
                  <!-- Conditionally include security fee row -->
                  ${showSecurityFeeRow ? `
                  <tr>
                    <td>Security Fee</td>
                    <td>KES ${this.formatNumber(this.unitSecurityFee)}</td>
                  </tr>
                  ` : ''}
                </tbody>
                <tfoot>
                  <tr>
                    <th>Total Amount Due:</th>
                    <td>KES ${this.formatNumber(this.total)}</td>
                  </tr>
                  <tr>
                    <th>Amount Paid:</th>
                    <td>KES ${this.formatNumber(this.amountPaid)}</td>
                  </tr>
                  <tr>
                    <th>Balance:</th>
                    <td>KES ${this.formatNumber(this.balAmount)}</td>
                  </tr>
                </tfoot>
              </table>
              <div class="receipt-footer">
                <p>You were served by ${this.user.first_name} ${this.user.last_name}.Thank you for your payment.</p>
                <p>This receipt acknowledges the payment received for the above property management services.</p>
              </div>
            </div>
          </body>
          </html>


          `;

          return receiptHTML;
        },
        exportToExcel() {
          const invoicesData = this.statements.map(statement => ({
            "PROPERTY": statement.property ? statement.property.name : 'N/A',
            "H/S NO": statement.unit ? statement.unit.unit_number : 'N/A',
            "TENANT": statement.tenant ? statement.tenant.first_name + ' ' + statement.tenant.last_name : 'N/A',
            "DUE": this.formatNumber(statement.total),
            "RENT": statement.unit ? this.formatNumber(statement.unit.monthly_rent) : 'N/A',
            "GARBAGE": statement.unit ? this.formatNumber(statement.unit.garbage_fee) : 'N/A',
            "WATER": this.formatNumber(statement.water_bill ?? "N/A"),
            "PAID": this.formatNumber(statement.paid),
            "BALANCE": this.formatNumber(statement.balance),
            "PAID ON": this.format_date(statement.paid_at ?? "N/A"),
          }));

          const worksheet = XLSX.utils.json_to_sheet(invoicesData);
          const workbook = XLSX.utils.book_new();
          XLSX.utils.book_append_sheet(workbook, worksheet, "INVOICES");

          // Customize the filename with a timestamp
          const timestamp = new Date().toISOString().slice(0, 19).replace(/-/g, "").replace(/:/g, "").replace(/T/g, "_");
          const filename = `${this.tenantName}_QUARTERLY_INVOICES_${timestamp}.xlsx`;
          
          XLSX.writeFile(workbook, filename);
        },
        generatePDF() {
            let pdfName = 'Full Statement';
            var doc = new jsPDF('landscape');
            const firstPageMaxRows = 13; // Rows for the first page
            const subsequentPagesMaxRows = 30; // Rows for subsequent pages

            // Add top-left header
            const rightHeaderText = 'April Properties\nKakamega-Webuye Rd, ACK Building\nTel: 0720 020 401\nP. O. Box 2973-50100, Kakamega\nEmail: propertapril@gmail.com';
            const rightHeaderFontSize = 12;
            const rightheaderX = 20; // Adjust the X coordinate
            const rightheaderY = 10;

            doc.setFontSize(rightHeaderFontSize);
            doc.setTextColor(44, 62, 80);
            doc.text(rightHeaderText, rightheaderX, rightheaderY, { align: 'left' });

            // Add top-right header
            const headerText = 'Generated on: ' + new Date().toLocaleString()+'\n'+'Tenant: '+this.tenantName+'\n'+'ID Number: '+this.tenant.id_number + '\n'+'Phone: '+this.tenant.phone_number+'\n'+this.tenant.property.name+'\n'+this.tenant.unit.unit_number;
            const headerFontSize = 12;
            const headerX = doc.internal.pageSize.width - 20; // Adjust the X coordinate
            const headerY = 10;

            doc.setFontSize(headerFontSize);
            doc.setTextColor(44, 62, 80);
            doc.text(headerText, headerX, headerY, { align: 'right' });

            // Add image at the top
            const imageUrl = '/images/apex-logo.png'; // Replace with the URL of your image
            const imageWidth = 50; // Adjust the width of the image as needed
            const imageHeight = 50; // Adjust the height of the image as needed
            const imageX = (doc.internal.pageSize.width - imageWidth) / 2;
            const imageY = 20;
            doc.addImage(imageUrl, 'JPEG', imageX, imageY, imageWidth, imageHeight);

            // Add title
            const titleText = (this.tenantName + " " + 'Quarterly' + ' Rent Statement').toUpperCase();
            const titleFontSize = 16;
            const titleWidth = doc.getStringUnitWidth(titleText) * titleFontSize / doc.internal.scaleFactor;
            const titleX = (doc.internal.pageSize.width - titleWidth) / 2;
            const titleY = imageY + imageHeight + 10;

            doc.setFontSize(titleFontSize);
            doc.setTextColor(44, 62, 80); // Set text color to a dark shade
            doc.text(titleText, titleX, titleY);

            const roundedCommission = Math.round(this.property.commission * 100);
            const commissionTotal = this.propertyCommission / 100 * this.totalPaid;
            const netRemissionTotal = Math.round(this.totalPaid - (this.totalAmountPaid + commissionTotal));

            // Add content headers

            doc.setFontSize(14);
            doc.setTextColor(52, 73, 94); // Set text color to a slightly lighter shade

            let textY = imageY + imageHeight + 20; // Initial y-coordinate for the first text

            doc.text('Total Rent Due: ' + 'KES ' + this.formatNumber(this.totalDue), 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.text('Total Rent Paid: '+ 'KES ' +this.formatNumber(this.totalPaid), 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.text('Total Balance: ' + 'KES ' + this.formatNumber(this.totalBalance) , 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            // Set font size for the table headers and data
            const tableFontSize = 8;
            doc.setFontSize(tableFontSize);
            doc.setTextColor(0);

            let headerYPos = imageY + imageHeight + 45;
            let cellHeight = 10;
            let cellPadding = 2;
            let lineHeight = 5;
            let columnWidths = [20, 50, 20, 20, 20, 20, 20, 20, 30]; // Adjusted column widths for 9 columns
            let columnHeaders = ['H/S NO.', 'TENANT NAME', 'DUE', 'RENT', 'GARBAGE', 'WATER', 'PAID', 'BALANCE', 'DATE PAID']; // Example headers

            let xPos = 20;
            doc.setDrawColor(0);

            for (let i = 0; i < columnWidths.length; i++) {
                doc.rect(xPos, headerYPos, columnWidths[i], cellHeight);
                doc.setTextColor(0); // Set text color to black
                doc.text(columnHeaders[i], xPos + cellPadding, headerYPos + cellHeight - cellPadding);
                xPos += columnWidths[i];
            }

            let currentPage = 1;
            let currentRow = 0;
            let maxRowsPerPage = firstPageMaxRows; // Set initial max rows for the first page

            // Initialize totals
            let totals = Array(columnHeaders.length).fill(0);

            this.statements.forEach((statement, index) => {
                if (currentRow >= maxRowsPerPage) {
                    doc.addPage();
                    headerYPos = 20;
                    currentRow = 0;
                    currentPage++;
                    maxRowsPerPage = subsequentPagesMaxRows; // Set max rows for subsequent pages

                    xPos = 20;
                    for (let i = 0; i < columnWidths.length; i++) {
                        doc.rect(xPos, headerYPos, columnWidths[i], cellHeight, 'F');
                        doc.setTextColor(0); // Set text color to black
                        doc.text(columnHeaders[i], xPos + cellPadding, headerYPos + cellHeight - cellPadding);
                        xPos += columnWidths[i];
                    }
                    headerYPos += cellHeight;
                }

                let yPos = headerYPos + (currentRow + 1) * lineHeight;
                xPos = 20;
                for (let i = 0; i < columnWidths.length; i++) {
                    doc.rect(xPos, yPos, columnWidths[i], cellHeight);
                    switch (i) {
                        case 0:
                            const unitNumber = statement.unit ? statement.unit.unit_number : 'N/A';
                            const truncatedText = unitNumber.length > 4 ? unitNumber.slice(0, 4) + '...' : unitNumber;
                            doc.text(truncatedText, xPos + cellPadding, yPos + cellHeight - cellPadding);
                            break;
                        case 1:
                            doc.text(
                                statement.tenant ? `${statement.tenant.first_name} ${statement.tenant.last_name}` : 'Vacant',
                                xPos + cellPadding,
                                yPos + cellHeight - cellPadding
                            );
                            break;
                        case 2:
                            doc.text(this.formatNumber(statement.total), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            totals[2] += parseFloat(statement.total) || 0;
                            break;
                        case 3:
                            let monthlyRent = statement.unit ? parseFloat(statement.unit.monthly_rent) : 0;
                            doc.text(this.formatNumber(monthlyRent), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            totals[3] += monthlyRent || 0;
                            break;
                        case 4:
                            let garbageFee = statement.unit ? parseFloat(statement.unit.garbage_fee) : 0;
                            doc.text(this.formatNumber(garbageFee), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            totals[4] += garbageFee || 0;
                            break;
                        case 5:
                            let waterBill = parseFloat(statement.water_bill) || 0;
                            doc.text(this.formatNumber(waterBill), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            totals[5] += waterBill;
                            break;
                        case 6:
                            let paidAmount = parseFloat(statement.paid) || 0;
                            doc.text(this.formatNumber(paidAmount), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            totals[6] += paidAmount;
                            break;
                        case 7:
                            let balance = parseFloat(statement.balance) || 0;
                            doc.text(this.formatNumber(balance), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            totals[7] += balance;
                            break;
                        case 8:
                            doc.text(this.format_date(statement.paid_at ?? 'N/A'), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            break;
                    }
                    xPos += columnWidths[i];
                }
                currentRow++;
            });

            // Add totals row
            let totalsYPos = headerYPos + (currentRow + 1) * lineHeight;
            xPos = 20;
            doc.setDrawColor(0);
            for (let i = 0; i < columnWidths.length; i++) {
                doc.rect(xPos, totalsYPos, columnWidths[i], cellHeight);
                if (i > 1 && i < columnWidths.length - 1) { // Skip first two and last column
                    doc.text(this.formatNumber(totals[i]), xPos + cellPadding, totalsYPos + cellHeight - cellPadding);
                }
                xPos += columnWidths[i];
            }

            // Add footer
            doc.setFontSize(10);
            doc.text('Generated on: ' + new Date().toLocaleString(), 20, doc.internal.pageSize.height - 10);

            // Save the PDF
            let fileName = this.tenantName + " " + 'Quarterly' + ' Rent Statement' + '_Total_Pages_' + currentPage + '.pdf';
            doc.save(fileName);
        },
      //   generatePDF() {
      //       let pdfName = 'Full Statement';
      //       var doc = new jsPDF('landscape');
      //       const maxRowsPerPage = 13; // Adjust this value based on the number of rows you want per page

      //       // Add top-left header
      //       const rightHeaderText = 'April Properties\nKakamega-Webuye Rd, ACK Building\nTel: 0720 020 401\nP. O. Box 2973-50100, Kakamega\nEmail: propertapril@gmail.com';
      //       const rightHeaderFontSize = 12;
      //       const rightheaderX = 20; // Adjust the X coordinate
      //       const rightheaderY = 10;

      //       doc.setFontSize(rightHeaderFontSize);
      //       doc.setTextColor(44, 62, 80);
      //       doc.text(rightHeaderText, rightheaderX, rightheaderY, { align: 'left' });

      //       // Add top-right header
      //       const headerText = 'Generated on: ' + new Date().toLocaleString()+'\n'+'Tenant: '+this.tenantName+'\n'+'ID Number: '+this.tenant.id_number + '\n'+'Phone: '+this.tenant.phone_number+'\n'+this.tenant.property.name+'\n'+this.tenant.unit.unit_number;
      //       const headerFontSize = 12;
      //       const headerX = doc.internal.pageSize.width - 20; // Adjust the X coordinate
      //       const headerY = 10;

      //       doc.setFontSize(headerFontSize);
      //       doc.setTextColor(44, 62, 80);
      //       doc.text(headerText, headerX, headerY, { align: 'right' });


      //       // Add image at the top
      //       const imageUrl = '/images/apex-logo.png'; // Replace with the URL of your image
      //       const imageWidth = 50; // Adjust the width of the image as needed
      //       const imageHeight = 50; // Adjust the height of the image as needed
      //       const imageX = (doc.internal.pageSize.width - imageWidth) / 2;
      //       const imageY = 20;
      //       doc.addImage(imageUrl, 'JPEG', imageX, imageY, imageWidth, imageHeight);

      //       // Add title
      //       const titleText = (this.tenantName+"'s "+this.formatMonth(new Date)+' Rent Statement').toUpperCase();
      //       const titleFontSize = 18;
      //       const titleWidth = doc.getStringUnitWidth(titleText) * titleFontSize / doc.internal.scaleFactor;
      //       const titleX = (doc.internal.pageSize.width - titleWidth) / 2;
      //       const titleY = imageY + imageHeight + 10;

      //       doc.setFontSize(titleFontSize);
      //       doc.setTextColor(44, 62, 80); // Set text color to a dark shade
      //       doc.text(titleText, titleX, titleY);

      //       // // Add subtitle with date information
      //       // doc.setFontSize(14);
      //       // doc.setTextColor(52, 73, 94); // Set text color to a slightly lighter shade
      //       // doc.text('Generated on: ' + new Date().toLocaleString(), 20, imageY + imageHeight + 20);

      //       // const roundedCommission = Math.round(this.property.commission * 100);
      //       // const commissionTotal = roundedCommission/100*this.totalPaid;

      //       // const netRemissionTotal = Math.round(this.totalPaid - (this.totalAmountPaid + commissionTotal));

      //       // Add content headers
      //       // doc.setFontSize(14);
      //       // doc.setTextColor(44, 62, 80);
      //       // doc.text(roundedCommission +'% Commission: '+ 'KES ' +this.formatNumber(commissionTotal), 20, imageY + imageHeight + 35);



      //       doc.setFontSize(14);
      //       doc.setTextColor(52, 73, 94); // Set text color to a slightly lighter shade

      //       let textY = imageY + imageHeight + 20; // Initial y-coordinate for the first text

      //       doc.text('Total Rent Due: ' + 'KES ' + this.formatNumber(this.totalDue), 20, textY);
      //       textY += 10; // Increment y-coordinate for the next text

      //       doc.text('Total Rent Paid: '+ 'KES ' +this.formatNumber(this.totalPaid), 20, textY);
      //       textY += 10; // Increment y-coordinate for the next text

      //       doc.text('Total Balance: ' + 'KES ' + this.formatNumber(this.totalBalance) , 20, textY);
      //       textY += 10; // Increment y-coordinate for the next text

      //       doc.setFontSize(12);
      //       doc.setTextColor(0);

      //       let headerYPos = imageY + imageHeight + 45;
      //       let cellHeight = 10;
      //       let cellPadding = 2;
      //       let lineHeight = 5;
      //       let columnWidths = [60, 30, 70, 30, 30, 30];
      //       let columnHeaders = ['Invoiced On', 'Status', 'Detail', 'Due', 'Paid', 'Bal'];

      //       let xPos = 20;
      //       doc.setDrawColor(0);

      //       for (let i = 0; i < columnWidths.length; i++) {
      //           doc.rect(xPos, headerYPos, columnWidths[i], cellHeight);
      //           doc.setTextColor(0); // Set text color to black
      //           doc.text(columnHeaders[i], xPos + cellPadding, headerYPos + cellHeight - cellPadding);
      //           xPos += columnWidths[i];
      //       }

      //       let currentPage = 1;
      //       let currentRow = 0;

      //       this.statements.forEach((statement, index) => {
      //           if (currentRow >= maxRowsPerPage) {
      //               doc.addPage();
      //               headerYPos = 20;
      //               currentRow = 0;
      //               currentPage++;
      //               xPos = 20;
      //               for (let i = 0; i < columnWidths.length; i++) {
      //                   doc.rect(xPos, headerYPos, columnWidths[i], cellHeight, 'F');
      //                   doc.setTextColor(0); // Set text color to black
      //                   doc.text(columnHeaders[i], xPos + cellPadding, headerYPos + cellHeight - cellPadding);
      //                   xPos += columnWidths[i];
      //               }
      //               headerYPos += cellHeight;
      //           }

      //           let yPos = headerYPos + (currentRow + 1) * lineHeight;
      //           xPos = 20;
      //           for (let i = 0; i < columnWidths.length; i++) {
      //               doc.rect(xPos, yPos, columnWidths[i], cellHeight);
      //               switch (i) {
      //                   case 0:
      //                       doc.text(this.format_date(statement.updated_at), xPos + cellPadding, yPos + cellHeight - cellPadding);
      //                       break;
      //                   case 1:
      //                       let statusText = statement.status == 1 ? 'Settled' : 'Not Settled';
      //                       doc.text(statusText, xPos + cellPadding, yPos + cellHeight - cellPadding);
      //                       break;
      //                   case 2:
      //                       doc.text(statement.details, xPos + cellPadding, yPos + cellHeight - cellPadding);
      //                       break;
      //                   case 3:
      //                       doc.text(this.formatNumber(statement.total), xPos + cellPadding, yPos + cellHeight - cellPadding);
      //                       break;
      //                   case 4:
      //                       doc.text(this.formatNumber(statement.paid), xPos + cellPadding, yPos + cellHeight - cellPadding);
      //                       break;
      //                   case 5:
      //                       doc.text(this.formatNumber(statement.balance), xPos + cellPadding, yPos + cellHeight - cellPadding);
      //                       break;
      //               }
      //               xPos += columnWidths[i];
      //           }
      //           currentRow++;

      //       });
            

      //       // Add subtitle with date information
            
      //       // Add footer
      //       doc.setFontSize(10);
      //       doc.text('Generated on: ' + new Date().toLocaleString(), 20, doc.internal.pageSize.height - 10);





      //       // Call the function to add expenses to the PDF with pagination
      //       // let totalPages = this.addExpensesToPDF(this.expenses, doc);
      //       // Save the PDF
      //       let fileName = this.tenantName +"'s ' "+ this.formatMonth(new Date)+' Rent Statement' + '_Page_' + currentPage + '.pdf';
      //       // let fileName = this.property.name+" "+this.formatMonth(this.property.created_at)+' Rent Statement' + '_Total_Pages_' + totalPages + '.pdf';

      //       doc.save(fileName);
      // },
      },
      components : {
          TheMaster,
      },
      mounted(){
        this.getTenant();
        this.getTenantStatements();
        this.setLastMonth();
        this.user = localStorage.getItem('user');
        this.user = JSON.parse(this.user);
        this.loadLogo();        
        this.currentDate = this.getCurrentDate(); // Set the initial date
        this.updateTime(); // Set the initial time
        setInterval(this.updateTime, 1000); // Update the time every second
        this.currentMonth = this.getCurrentMonth(); // Set the initial date

      },
      computed: {
      // Calculate total based on the provided key ('total', 'paid', 'balance')
      // calculateTotal() {
      //     return (key) => {
      //       return this.formatNumber(
      //         this.statements.reduce((acc, statement) => acc + parseFloat(statement[key]), 0)
      //       );
      //     };
      //   },
         // Computed property to calculate total due
        totalDue() {
          return this.calculateTotal('total');
        },
        // Computed property to calculate total paid
        totalPaid() {
          return this.calculateTotal('paid');
        },
        // Computed property to calculate total balance
        totalBalance() {
          return this.calculateTotal('balance');
        },
        totalGarbage() {
          return this.calculateTotal('garbage_fee');
        },
        payableAmount() {

            if (this.paid > 0) {
              return this.balance - this.form.cash;
            }
            else
            {
               return this.total - this.form.cash; // Multiply inputValue by 2 (change this multiplier as needed)
            } 
          
       
        },
        payableOverAmount() {
            return this.total - this.paid; // Multiply inputValue by 2 (change this multiplier as needed                              
        },    
      },
    }
    </script>
    
    
    