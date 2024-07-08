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
    
                        <li>
                            <router-link to="/statements/" custom v-slot="{ href, navigate, isActive }">
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
                            <router-link to="/pmsyearstatements" custom v-slot="{ href, navigate, isActive }">
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
                            <router-link to="/pmsallstatements" custom v-slot="{ href, navigate, isActive }">
                            <a
                                :href="href"
                                :class="{ active: isActive }"
                                class="dropdown-item"
                                @click="navigate"
                            >
                            All Time</a>
                            </router-link>
                        </li>

                      </ul> -->
                    </div>
    
                    <div class="card-body pb-0">
                      <h5 class="card-title">Awaiting Invoicing - {{property.name}} <span>| {{statements.length}} awaiting invoicing</span></h5>
                      <p class="card-text">
                        <div class="row">
                          <div class="col d-flex">
                            <button class="me-2" v-if="statements.length !== 0" @click="exportToExcel">Export</button>  
                            <router-link to="#" custom v-slot="{ href, navigate, isActive }">
                                <a
                                  :href="href"
                                  :class="{ active: isActive }"
                                  v-if="statements.length !== 0"
                                  class="btn btn-sm btn-primary rounded-pill me-2"
                                  style="background-color: darkorange; border-color: darkorange;"
                                >
                                  ({{statements.length}}) Remaining
                                </a>
                            </router-link>                      
                            <!-- <button v-if="statements.length !== 0" @click="generatePDF">Generate PDF</button> -->
                          </div>
                          <div class="col-auto d-flex justify-content-end">
                          <div class="btn-group" role="group">
                              <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-add-line"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a @click="navigateTo('/pmspropertystatements/'+property.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View Invoices</a>
                                    <a @click="navigateTo('/propertyawaitinginvoicing/'+property.id)" class="dropdown-item" href="#">
                                      <i class="ri-file-list-2-fill mr-2"></i>Awaiting Invoicing
                                    </a>
                                    <a @click="navigateTo('/propertyinvoicestosettle/'+property.id)" class="dropdown-item" href="#">
                                      <i class="ri-file-edit-fill mr-2"></i>Invoices to Settle
                                    </a>
                                    <a @click="navigateTo('/propertysettledinvoices/'+property.id)" class="dropdown-item" href="#">
                                      <i class="ri-bank-card-fill mr-2"></i>Settled Invoices
                                    </a>
   
                                    <a @click="navigateTo('/edit-pmsproperty/'+property.id )" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                                     <a @click="navigateTo('/managedproperties' )" class="dropdown-item" href="#"><i class="ri-building-fill mr-2"></i>Properties</a>
                                    <a @click="navigateTo('/pmslandlords' )" class="dropdown-item" href="#"><i class="ri-user-fill mr-2"></i>Landlords</a>
                              </div>
                            </div>
                          </div>
                        </div>  
            
                      </p>
    
                      <table id="AllStatementsTable" class="table table-borderless">
                        <thead>
                          <tr>
                            <th scope="col">H/S No.</th>
                            <th scope="col">Tenant</th>
                            <th scope="col">Due</th>
                            <th scope="col">Rent</th>
                            <th scope="col">Garbage</th>
                            <th scope="col">Water</th>
                            <th scope="col">Generated On</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="statement in statements" :key="statement.id">
                            <td>{{ statement.unit_number ?? 'N/A' }}</td>
                            <td>{{ statement.tenant ? statement.tenant.first_name + ' ' + statement.tenant.last_name : 'N/A' }}</td>
                            <td>{{formatNumber(statement.total)}}</td>
                            <td>{{ statement.unit ? formatNumber(statement.unit.monthly_rent) : 'N/A' }}</td>
                            <td>{{ statement.unit ? formatNumber(statement.unit.garbage_fee) : 'N/A' }}</td>
                            <td>{{formatNumber(statement.water_bill ?? "N/A")}}</td>
                            <td>{{format_date(statement.created_at)}}</td>
                            <td>
                              <span v-if="statement.status == 0 && statement.water_bill == null" class="badge bg-info text-dark"><i class="bi bi-clipboard2-x"></i> Not Invoiced</span>
                              <span v-else-if="statement.status == 1" class="badge bg-success"><i class="bi bi-clipboard2-check"></i> Settled</span>
                              <span v-else-if="statement.status == 0 && statement.water_bill !== null" class="badge bg-warning text-dark"><i class="bi bi-clipboard2-x"></i> Not Settled</span>
                              <span v-else class="badge bg-dark text-light"><i class="bi bi-exclamation-triangle me-1"></i> Vacant</span>
                            </td>
                            <!-- <td>{{format_date(statement.created_at)}}</td> -->
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a @click="navigateTo('/viewstatement/'+statement.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>                                            
                                  <a v-if="statement.status == 0 && statement.water_bill == null" @click="invoiceTenant(statement)" class="dropdown-item" href="#"><i class="ri-bill-line mr-2"></i>Invoice</a>
                                  <a v-if="statement.status == 0 && statement.water_bill !== null" @click="settleTenant(statement.id, statement.pms_tenant_id)" class="dropdown-item" href="#"><i class="ri-check-fill mr-2"></i>Settle</a>
                                  </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div><strong>Total: 
                        Due: {{ formatNumber(calculateTotal('total')) }},
                        Paid: {{ formatNumber(calculateTotal('paid')) }},
                        Bal: {{ formatNumber(calculateTotal('balance')) }}
                      </strong>
                      </div>     
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
                              <strong>Water Bill:</strong>(optional)
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
          collectedTotal: 0,
          expensesTotal: 0,
          user: [],
          property: '',
          selectedStatement: {}, // Initialize as an empty object
          form: {
            water_bill : ''
          },
          errors: {
            water_bill: ''
          },
          loading: false,
          invoicedTenantPhone: '',
          invoicedTenantName: '',
          dueWater: '',
          dueAmount: ''
        }
      },
      methods: {
        navigateTo(location){
            this.$router.push(location)
        },
         invoiceTenant(id){
            this.$router.push('invoicestatement/'+id)
        },
        getProperty()
        {
          axios.get('/api/pmsproperty/'+ this.$route.params.id).then((response) => {
            this.property = response.data.property;
            this.commission = this.property.landlord.commission;
            this.fixedCommission = this.property.landlord.fixed_commission;
            if(this.commission !== null)
            {
              this.propertyCommission = this.commission
            }
            else
            {
              this.propertyCommission = this.fixedCommission;
            }
            // else
            // {
            //   this.propertyCommission = '';
            // }
            console.log("commission", this.propertyCommission)
          }).catch(() => {
              console.log('error')
          })
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
          // if (!this.form.water_bill) {
          //   this.errors.water_bill = 'Water bill is required.';
          //   return;
          // }

          if (this.selectedStatement && this.selectedStatement.id) {
            // Show loading spinner
            this.loading = true;
            this.successMessage = '';

            // Implement your logic to invoice the tenant here
            console.log("Invoicing tenant with statement ID:", this.selectedStatement.id);
            axios.put("/api/pmsinvoicestatement/" + this.selectedStatement.id, this.form)
              .then(response => {
                this.invoiceStatement = response.data.statement
                // this.sendSms(this.invoiceStatement);
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
                this.loadLists();
              });
          }
        },
        async loginUwazii() {
          try {
            const data = JSON.stringify({
              "username": "April_Properties",
              "password": "Mosobo*123#"
            });

            const config = {
              method: 'post',
              maxBodyLength: Infinity,
              url: 'https://restapi.uwaziimobile.com/v1/authorize',
              headers: {
                'Content-Type': 'application/json'
              },
              data: data
            };

            const response = await axios(config);
            this.authorizationCode = response.data.data.authorization_code; // Save authorizationCode into this.authorizationCode
            console.log(this.authorizationCode);
          } catch (error) {
            console.log(error);
          }
        },

        async getAccessToken() {
          try {
            const data = JSON.stringify({
              "authorization_code": this.authorizationCode
            });

            const config = {
              method: 'post',
              maxBodyLength: Infinity,
              url: 'https://restapi.uwaziimobile.com/v1/accesstoken',
              headers: {
                'Content-Type': 'application/json'
              },
              data: data
            };

            const response = await axios(config);
            this.accessToken = response.data.data.access_token; // Save accessToken into this.accessToken
            console.log(this.accessToken);
          } catch (error) {
            console.log(error);
          }
        },

        async sendSms(statement) {
              await this.loginUwazii();
              await this.getAccessToken();
              console.log("uhunye", statement);
              const dueAmount = statement.total;
              const dueWater = statement.water_bill;
              const tenantId = statement.pms_tenant_id;

              // Fetch tenant data and wait for it to complete
              await this.getTenant(tenantId);

              // Ensure tenant details are available before creating the payload
              const payload = {
                  'token': this.accessToken,
                  'tenantName': this.invoicedTenantName,
                  'dueWater': dueWater,  // Use the dueWater from statement
                  'dueAmount': dueAmount,  // Use the dueAmount from statement
                  'number': this.formatPhoneNumber(this.invoicedTenantPhone.toString()) // Format the phone number
              };

              axios.post('/api/sendsms', payload)
                  .then((response) => {
                      console.log("sms status", payload);
                  })
                  .catch((error) => {
                      console.error("Error sending sms:", error);
                  });
          },

        async getTenant(id) {
              try {
                  const response = await axios.get('/api/pmstenant/' + id);
                  this.tenant = response.data.tenant;
                  console.log("omollo", this.tenant);
                  this.invoicedTenantName = this.tenant.first_name;
                  this.invoicedTenantPhone = this.tenant.phone_number;
              } catch (error) {
                  console.log('error', error);
              }
        },

        formatPhoneNumber(number) {
            // Ensure number is a string
            number = number.toString();
            
            // Clean the phone number and ensure it has the 254 prefix
            if (number.startsWith('0')) {
                // Remove the leading zero and add the 254 prefix
                number = '254' + number.substring(1);
            } else if (!number.startsWith('254')) {
                // If the number is not already prefixed with 254, add it
                number = '254' + number;
            }
            return number;
        },

        settleTenant(id, tenantId){
            // this.$router.push('/settlestatement/'+id)
            this.$router.push({ 
              name: 'settlestatement', // Assuming you have named routes
              params: { 
                id: id,
                tenantId: tenantId
              } 
            });

        },
        capitalizeFirstLetter(str) {
          return str.charAt(0).toUpperCase() + str.slice(1);
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
        capitalizeFirstLetter(str) {
          return str.charAt(0).toUpperCase() + str.slice(1);
        },
        generatePDF() {
            let pdfName = 'Full Statement';
            var doc = new jsPDF('landscape');
            const maxRowsPerPage = 13; // Adjust this value based on the number of rows you want per page

            // Add top-left header
            const rightHeaderText = 'April Properties\nKakamega-Webuye Rd, ACK Building\nTel: 0720 020 401\nP. O. Box 2973-50100, Kakamega\nEmail: propertapril@gmail.com';
            const rightHeaderFontSize = 12;
            const rightheaderX = 20; // Adjust the X coordinate
            const rightheaderY = 10;

            doc.setFontSize(rightHeaderFontSize);
            doc.setTextColor(44, 62, 80);
            doc.text(rightHeaderText, rightheaderX, rightheaderY, { align: 'left' });

            // Add top-right header
            const headerText = 'Generated on: ' + new Date().toLocaleString();
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
            const titleText = (' Full Rent Statement').toUpperCase();
            const titleFontSize = 18;
            const titleWidth = doc.getStringUnitWidth(titleText) * titleFontSize / doc.internal.scaleFactor;
            const titleX = (doc.internal.pageSize.width - titleWidth) / 2;
            const titleY = imageY + imageHeight + 10;

            doc.setFontSize(titleFontSize);
            doc.setTextColor(44, 62, 80); // Set text color to a dark shade
            doc.text(titleText, titleX, titleY);



            // // Add subtitle with date information
            // doc.setFontSize(14);
            // doc.setTextColor(52, 73, 94); // Set text color to a slightly lighter shade
            // doc.text('Generated on: ' + new Date().toLocaleString(), 20, imageY + imageHeight + 20);

            const netRentTotal = this.totalPaid - this.totalAmountPaid;          

            doc.setFontSize(14);
            doc.setTextColor(52, 73, 94); // Set text color to a slightly lighter shade

            let textY = imageY + imageHeight + 20; // Initial y-coordinate for the first text

            doc.text('Total Rent Collected: '  + 'KES ' + this.formatNumber(this.totalPaid), 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.text('Total Expenses Incurred: '  + 'KES ' + this.formatNumber(this.totalAmountPaid), 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.text('Total Rent Less Expenses: ' + 'KES ' + this.formatNumber(netRentTotal) , 20, textY);
            textY += 10; // Increment y-coordinate for the next text
            

            doc.setFontSize(12);
            doc.setTextColor(0);

            let headerYPos = imageY + imageHeight + 45;
            let cellHeight = 10;
            let cellPadding = 2;
            let lineHeight = 5;
            let columnWidths = [60, 30, 70, 30, 30, 30];
            let columnHeaders = ['Invoiced On', 'Status', 'Detail', 'Total', 'Paid', 'Bal'];

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

            this.statements.forEach((statement, index) => {
                if (currentRow >= maxRowsPerPage) {
                    doc.addPage();
                    headerYPos = 20;
                    currentRow = 0;
                    currentPage++;
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
                            doc.text(this.format_date(statement.updated_at), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            break;
                        case 1:
                        let statusText;

                        if (statement.status === 1) {
                            statusText = 'Settled';
                        } else if (statement.status === 0) {
                            statusText = 'Not Settled';
                        } else {
                            statusText = 'Vacant';
                        }
                            doc.text(statusText, xPos + cellPadding, yPos + cellHeight - cellPadding);
                            break;
                        case 2:
                            doc.text(statement.details, xPos + cellPadding, yPos + cellHeight - cellPadding);
                            break;
                        case 3:
                            doc.text(this.formatNumber(statement.total), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            break;
                        case 4:
                            doc.text(this.formatNumber(statement.paid), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            break;
                        case 5:
                            doc.text(this.formatNumber(statement.balance), xPos + cellPadding, yPos + cellHeight - cellPadding);
                            break;
                    }
                    xPos += columnWidths[i];
                }
                currentRow++;

            });
            

            // Add subtitle with date information
            
            // Add footer
            doc.setFontSize(10);
            doc.text('Generated on: ' + new Date().toLocaleString(), 20, doc.internal.pageSize.height - 10);



            // Call the function to add expenses to the PDF with pagination
            let totalPages = this.addExpensesToPDF(this.expenses, doc);
            // Save the PDF
            // let fileName = 'Full Statement' + '_Page_' + currentPage + '.pdf';
            let fileName = 'Full Statement' + '_Total_Pages_' + totalPages + '.pdf';

            doc.save(fileName);
        },
        // Function to add expenses to the PDF with pagination
        addExpensesToPDF(expenses, doc) {
            // Add content headers for expenses
            doc.addPage(); // Add a new page for Expenses
            doc.setFontSize(14);
            doc.setTextColor(44, 62, 80);
            doc.text('Expenses', 20, 20);

            doc.setFontSize(12);
            doc.setTextColor(0);

            // Draw table headers and borders dynamically based on the HTML structure
            let expenseHeaderYPos = 30;
            let expenseCellHeight = 10;
            let expenseCellPadding = 2;
            let expenseLineHeight = 5;
            let expenseColumnWidths = [60, 40, 60, 30, 60];

            // Define column headers for Expenses
            let expenseColumnHeaders = ['Type', 'Amount(KES)', 'Expended To', 'Checked By', 'Checked On'];

            // Draw headers with borders dynamically based on calculated column widths
            let expenseXPos = 20;
            doc.setDrawColor(0);
            doc.setFillColor(255, 255, 255); // Set header background color to white

            for (let i = 0; i < expenseColumnWidths.length; i++) {
                doc.setFillColor(255, 255, 255); // Set fill color to white
                doc.rect(expenseXPos, expenseHeaderYPos, expenseColumnWidths[i], expenseCellHeight, 'F');
                doc.setTextColor(0); // Set text color to black
                doc.text(expenseColumnHeaders[i], expenseXPos + expenseCellPadding, expenseHeaderYPos + expenseCellHeight - expenseCellPadding);
                expenseXPos += expenseColumnWidths[i];
            }


            let currentPage = 1;
            let currentRow = 0;
            const maxRowsPerPage = 28; // Adjust this value based on the number of rows you want per page

            // Iterate through expenses and add them to the PDF with dynamic borders
            expenses.forEach((expense, index) => {
                if (currentRow >= maxRowsPerPage) {
                    doc.addPage(); // Add a new page if the maximum rows per page is exceeded
                    expenseHeaderYPos = 20;
                    currentRow = 0;
                    currentPage++;
                    expenseXPos = 20;
                    // Draw headers for expenses on new page
                    for (let i = 0; i < expenseColumnWidths.length; i++) {
                        doc.rect(expenseXPos, expenseHeaderYPos, expenseColumnWidths[i], expenseCellHeight, 'F');
                        doc.setTextColor(0); // Set text color to black
                        doc.text(expenseColumnHeaders[i], expenseXPos + expenseCellPadding, expenseHeaderYPos + expenseCellHeight - expenseCellPadding);
                        expenseXPos += expenseColumnWidths[i];
                    }
                    expenseHeaderYPos += expenseCellHeight;
                }

                let yPos = expenseHeaderYPos + (currentRow + 1) * expenseLineHeight;
                expenseXPos = 20;
                // Add expense data
                for (let i = 0; i < expenseColumnWidths.length; i++) {
                    doc.rect(expenseXPos, yPos, expenseColumnWidths[i], expenseCellHeight);
                    switch (i) {
                        case 0:
                            doc.text(this.capitalizeFirstLetter(expense.payment_type), expenseXPos + expenseCellPadding, yPos + expenseCellHeight - expenseCellPadding);
                            break;
                        case 1:
                            doc.text(this.formatNumber(expense.amount_paid), expenseXPos + expenseCellPadding, yPos + expenseCellHeight - expenseCellPadding);
                            break;
                        case 2:
                            doc.text(expense.paid_to, expenseXPos + expenseCellPadding, yPos + expenseCellHeight - expenseCellPadding);
                            break;
                        case 3:
                            doc.text(`${expense.user.first_name} ${expense.user.last_name}`, expenseXPos + expenseCellPadding, yPos + expenseCellHeight - expenseCellPadding);
                            break;
                        case 4:
                            doc.text(this.format_date(expense.created_at), expenseXPos + expenseCellPadding, yPos + expenseCellHeight - expenseCellPadding);
                            break;
                    }
                    expenseXPos += expenseColumnWidths[i];
                }
                currentRow++;
            });
  
            doc.setFontSize(10);
            doc.text('Generated on: ' + new Date().toLocaleString(), 20, doc.internal.pageSize.height - 10);

            return currentPage; // Return the total number of pages used for expenses
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
            "GENERATED ON": this.format_date(statement.created_at ?? "N/A"),
          }));

          const worksheet = XLSX.utils.json_to_sheet(invoicesData);
          const workbook = XLSX.utils.book_new();
          XLSX.utils.book_append_sheet(workbook, worksheet, "AWAITING INVOICING");

          // Customize the filename with a timestamp
          const timestamp = new Date().toISOString().slice(0, 19).replace(/-/g, "").replace(/:/g, "").replace(/T/g, "_");
          const filename = `AWAITING_INVOICING_${timestamp}.xlsx`;
          
          XLSX.writeFile(workbook, filename);
        },
        loadLists() {
             axios.get('/api/propertyawaitinginvoicing/'+this.$route.params.id).then((response) => {
             this.statements = response.data.propertyawaitinginvoicing;
             console.log(response)
             // Calculate the total amount paid
            this.totalAmountPaid = this.calculateTotalAmountPaid();
             setTimeout(() => {
                  $("#AllStatementsTable").DataTable();
              }, 10);
    
             });
        },
        calculateTotalAmountPaid() {
        if (!this.expenses || this.expenses.length === 0) {
              return 0; // If expenses data is empty or undefined, return 0
            }

            // Use reduce to sum up the amount_paid property for all expenses
            return this.expenses.reduce((total, expense) => total + expense.amount_paid, 0);
        },
        calculateTotal(property) {
          // Function to calculate total for Total, Paid, and Bal columns

          return this.statements.reduce((total, statement) => total + (statement[property] || 0), 0);
        },
      },
      components : {
          TheMaster,
      },
      computed:
      {
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
        }
      },      
      mounted(){
        this.loadLists();
        this.getProperty();
        this.user = localStorage.getItem('user');
        this.user = JSON.parse(this.user);

      }
    }
    </script>
    
    
    