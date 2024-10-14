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
                            <router-link :to="`/propertysettledinvoices/${propertyId}`" custom v-slot="{ href, navigate, isActive }">
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
                            <router-link :to="`/propertylastmonthsettledinvoices/${propertyId}`" custom v-slot="{ href, navigate, isActive }">
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
                            <router-link :to="`/propertylastninetysettledinvoices/${propertyId}`" custom v-slot="{ href, navigate, isActive }">
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
                            <router-link :to="`/propertyquartersettledinvoices/${propertyId}`" custom v-slot="{ href, navigate, isActive }">
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
                            <router-link :to="`/propertylastyearsettledinvoices/${propertyId}`" custom v-slot="{ href, navigate, isActive }">
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
                            <router-link :to="`/propertyallsettledinvoices/${propertyId}`" custom v-slot="{ href, navigate, isActive }">
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
                      <h5 class="card-title">{{property.name}} Invoices <span>| This Month ({{currentMonth}})</span></h5>
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
                      <div class="row">
                        <div class="col d-flex">
                          <button class="me-2" v-if="allstatements.length !== 0" @click="exportToExcel">Export</button>
                          <button v-if="allstatements.length !== 0" @click="printInvoice" class="me-2">Print Landlord Invoice</button>
                          <button v-if="allstatements.length !== 0" @click="generatePDF" class="me-2">Generate Rent Statement</button>
                          <button v-if="allstatements.length !== 0" @click="sendMail">Send Landlord Email</button>
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
                            <th scope="col">Paid</th>
                            <th scope="col">Paid On</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="statement in allstatements" :key="statement.id">
                            <td>{{ statement.unit_number ?? 'N/A' }}</td>
                            <td>{{ statement.tenant ? statement.tenant.first_name + ' ' + statement.tenant.last_name : 'N/A' }}</td>
                            <td>{{formatNumber(statement.total)}}</td>
                            <td>{{ statement.unit ? formatNumber(statement.unit.monthly_rent) : 'N/A' }}</td>
                            <td>{{ statement.unit ? formatNumber(statement.unit.garbage_fee) : 'N/A' }}</td>
                            <td>{{formatNumber(statement.water_bill ?? "N/A")}}</td>
                            <td>{{formatNumber(statement.paid)}}</td>
                            <td>{{format_date(statement.paid_at)}}</td>
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
                                  <a @click="printReceipt(statement)" class="dropdown-item" href="#"><i class="ri-printer-line mr-2"></i>Print Receipt</a>
                  
                                  </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div><strong>Total: 
                        Rent: {{ formatNumber(calculateTotalRent()) }}
                        Due: {{ formatNumber(calculateTotal('total')) }},
                        Paid: {{ formatNumber(calculateTotal('paid')) }},
                        Bal: {{ formatNumber(calculateTotal('balance')) }}
                      </strong>
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
            statements: [],
            allstatements: [],
            collectedTotal: 0,
            expensesTotal: 0,
            user: [],
            property: '',
            name: '',
            tenant: '',
            phoneNumber: '',
            unitNumber: '',
            refNo: '',
            details: '',
            date: '',
            status: '',
            paid: '',
            balance: '',
            total: '',
            statementId: '',
            waterBill: '',
            unitRent: '',
            unitSecurityFee: '',
            unitGarbageFee: '',
            unitName: '',
            payment: '',
            date: new Date(), // Current date,
            currentTime: '',
            currentMonth:'',
            unitsNo: '',
            currentDate: '',
            netRemmission: '',
            rentLessCommission: '',
            landlordPhone: '',
            landlordEmail: '',
            landlordAddress: '',
            logoBase64: '',
            propertyId: '',
            currentTime: ''


        }
      },
      // created() {
      //   this.loadLogo();
      // },
      methods: {
        calculateTotalRent() {
          return this.allstatements.reduce((total, statement) => {
            if (statement.unit && statement.unit.monthly_rent) {
              return total + parseFloat(statement.unit.monthly_rent);
            }
            return total;
          }, 0);
        },
        navigateTo(location){
            this.$router.push(location)
        },
         invoiceTenant(id){
            this.$router.push('invoicestatement/'+id)
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
        formatted_date(value){
          if(value){
            return moment(String(value)).format('lll');
          }
        }, 
        capitalizeFirstLetter(str) {
          return str.charAt(0).toUpperCase() + str.slice(1);
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
        printInvoice() {
            // Open a new window for printing
            const printWindow = window.open("", "_blank");

            // Build the content for printing
            const invoiceContent = this.buildInvoiceContent();

            // Write the content to the new window
            printWindow.document.write(invoiceContent);

            // Close the document stream
            printWindow.document.close();

            // Wait for the content to be fully loaded
            printWindow.onload = function() {
                // Find the logo image element
                const logoImage = printWindow.document.querySelector('img');

                if (logoImage) {
                    // Ensure the image is loaded
                    logoImage.onload = function() {
                        // Trigger the print dialog after the image has loaded
                        printWindow.print();
                    };

                    // Handle case where the image might already be cached
                    if (logoImage.complete) {
                        logoImage.onload();  // Manually trigger onload if image is already loaded
                    }
                } else {
                    // If there's no image, just print immediately
                    printWindow.print();
                }
            };
        },

        buildInvoiceContent() {
          const logoBase64 = this.logoBase64 || ''; // Fallback if no logo is provided
          const watermarkText = 'INVOICE';

          // Determine whether to display each row based on the amounts
          const showCommercialProperty = this.commercialPropertyAmount > 0;
          const showResidentialProperty = this.residentialPropertyAmount > 0;
          const showPropertyExpense = this.totalAmountPaid > 0;

          const receiptHTML = `
            <!DOCTYPE html>
            <html lang="en">
            <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Landlord Invoice</title>
              <style>
                body {
                  font-family: 'Arial', sans-serif;
                  margin: 0;
                  padding: 0;
                  background-color: #f4f4f4;
                }
                .receipt {
                  max-width: 100%;
                  width: 650px;
                  margin: 40px auto;
                  padding: 30px;
                  background-color: #fff;
                  border: 1px solid #e0e0e0;
                  border-radius: 10px;
                  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                  position: relative;
                }
                .watermark {
                  position: absolute;
                  top: 50%;
                  left: 50%;
                  transform: translate(-50%, -50%) rotate(-45deg);
                  font-size: 80px;
                  color: rgba(0, 0, 0, 0.05);
                  z-index: 0;
                  pointer-events: none;
                }
                .receipt-header {
                  display: flex;
                  justify-content: space-between;
                  align-items: center;
                  margin-bottom: 30px;
                }
                .company-logo img {
                  max-width: 120px;
                  height: auto;
                }
                .company-info p {
                  margin: 0;
                  color: #333;
                  font-size: 14px;
                }
                .receipt-title {
                  text-align: center;
                  font-size: 26px;
                  font-weight: bold;
                  margin: 30px 0;
                  color: #444;
                }
                .receipt-info p {
                  margin: 2px 0;
                  color: #666;
                  font-size: 14px;
                  line-height: 1.6;
                }
                .receipt-table {
                  width: 100%;
                  border-collapse: collapse;
                  margin-bottom: 25px;
                }
                .receipt-table th, .receipt-table td {
                  padding: 12px 15px;
                  border-bottom: 1px solid #ddd;
                  text-align: left;
                }
                .receipt-table th {
                  background-color: #f7f7f7;
                  color: #333;
                  font-weight: 500;
                }
                .receipt-table td {
                  color: #555;
                  font-size: 14px;
                }
                .receipt-footer {
                  text-align: center;
                  margin-top: 30px;
                  color: #888;
                  font-size: 13px;
                }
                .footer-section {
                  text-align: center;
                  margin-top: 20px;
                  padding-top: 10px;
                  font-weight: bold;
                  font-size: 14px;
                  color: #444;
                  border-top: 1px solid #ddd;
                }
                .payment-section {
                  display: flex;
                  justify-content: space-between;
                  margin-top: 20px;
                  gap: 15px;
                }
                .payment-details, .additional-details {
                  width: 48%;
                  font-size: 14px;
                  color: #444;
                }
                .payment-details strong, .additional-details strong {
                  color: #333;
                }
                .note-section {
                  margin-top: 30px;
                  padding: 15px;
                  background-color: #f1f1f1;
                  border: 1px solid #ddd;
                  border-radius: 8px;
                  text-align: center;
                }
                .note-section p {
                  margin: 0;
                  font-size: 14px;
                  color: #666;
                  font-weight: bold;
                }
              </style>
            </head>
            <body>
              <div class="receipt">
                <div class="watermark">${watermarkText}</div>

                <div class="receipt-header">
                  <div class="company-logo">
                    <img src="${logoBase64}" alt="Company Logo">
                  </div>
                  <div class="company-info">
                    <p>${this.contacts?.address || 'No Address'}</p>
                    <p>Phone: ${this.formatPhoneNumber(this.contacts?.phone) || 'No Phone'}</p>
                    <p>Email: ${this.contacts?.email || 'No Email'}</p>
                    <p>Website: aprilproperties.co.ke</p>
                  </div>
                </div>

                <div class="receipt-info">
                  <p><strong>Invoice To:</strong> ${this.landlord || 'N/A'}</p>
                  <p><strong>Property:</strong> ${this.property?.name || 'N/A'}</p>
                  <p><strong>Date:</strong> ${this.format_date(new Date().toLocaleDateString())} at ${this.currentTime || 'N/A'}</p>
                </div>

                <div class="receipt-title">${this.currentMonth || 'Current'} Rent Statement</div>

                <table class="receipt-table">
                  <thead>
                    <tr>
                      <th>Particulars</th>
                      <th>@</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${showCommercialProperty ? `
                    <tr>
                      <td>Commercial Property Unit(s)</td>
                      <td>${this.propertyCommission || 'N/A'}</td>
                      <td>KES ${this.formatNumber(this.commercialPropertyAmount)}</td>
                    </tr>
                    ` : ''}
                    ${showResidentialProperty ? `
                    <tr>
                      <td>Residential Property Unit(s)</td>
                      <td>${this.propertyCommission || 'N/A'}</td>
                      <td>KES ${this.formatNumber(this.residentialPropertyAmount)}</td>
                    </tr>
                    ` : ''}
                    ${showPropertyExpense ? `
                    <tr>
                      <td>Property Expenses</td>
                      <td></td>
                      <td>KES ${this.formatNumber(this.totalAmountPaid )}</td>
                    </tr>
                    ` : ''}
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Total:</th>
                      <th></th>
                      <td>KES ${this.formatNumber(this.residentialPropertyAmount + this.commercialPropertyAmount + this.totalAmountPaid)}</td>
                    </tr>
                  </tfoot>
                </table>

                <div class="payment-section">
                  <div class="payment-details">
                    <p><strong>Bank Account Details:</strong></p>
                    <p>Bank: ${this.bankMoney?.bank_name || 'N/A'}</p>
                    <p>Account Name: ${this.bankMoney?.account_name || 'N/A'}</p>
                    <p>Account Number: ${this.bankMoney?.account_number || 'N/A'}</p>
                  </div>
                  <div class="additional-details">
                    <p><strong>Mobile Payment Details:</strong></p>
                    <p>PayBill: ${this.mobileMoney?.paybill_number || 'N/A'}</p>
                    <p>Account Number: ${this.mobileMoney?.account_number || 'N/A'}</p>
                    <p>Account Name: ${this.mobileMoney?.account_name || 'N/A'}</p>
                  </div>
                </div>

                <div class="note-section">
                  <p>Accounts are due on demand</p>
                </div>

                <div class="receipt-footer">
                
                </div>
                <div class="footer-section">
                  Property Management, Rent Enforcement, Property Advertising, Rental Income Tax
                </div>
              </div>
            </body>
            </html>
          `;

          return receiptHTML;
        },
        

        exportToExcel() {
          const invoicesData = this.allstatements.map(statement => ({
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
          XLSX.utils.book_append_sheet(workbook, worksheet, "SETTLED INVOICES");

          // Customize the filename with a timestamp
          const timestamp = new Date().toISOString().slice(0, 19).replace(/-/g, "").replace(/:/g, "").replace(/T/g, "_");
          const filename = `SETTLED_INVOICES_${timestamp}.xlsx`;
          
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
            const headerText = 'Generated on: ' + new Date().toLocaleString() + '\n' + 'Statement for:' + '\n' + this.landlord + '\n' + this.property.name + '\n' + this.landlordPhone + '\n' + this.landlordEmail;
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
            const titleText = (this.property.name + " " + this.currentMonth + ' Rent Statement').toUpperCase();
            const titleFontSize = 16;
            const titleWidth = doc.getStringUnitWidth(titleText) * titleFontSize / doc.internal.scaleFactor;
            const titleX = (doc.internal.pageSize.width - titleWidth) / 2;
            const titleY = imageY + imageHeight + 10;

            doc.setFontSize(titleFontSize);
            doc.setTextColor(44, 62, 80); // Set text color to a dark shade
            doc.text(titleText, titleX, titleY);

            const roundedCommission = Math.round(this.property.commission * 100);
            const commissionTotal = this.propertyCommission / 100 * this.totalRent;
            const netRemissionTotal = Math.round(this.totalRent - (this.totalAmountPaid + commissionTotal));

            // Add content headers
            doc.setFontSize(14);
            doc.setTextColor(44, 62, 80);
            doc.text('Total Expenses: ' + 'KES ' + this.formatNumber(this.totalAmountPaid), 20, imageY + imageHeight + 35);

            doc.setFontSize(14);
            doc.setTextColor(52, 73, 94); // Set text color to a slightly lighter shade

            let textY = imageY + imageHeight + 20; // Initial y-coordinate for the first text

            doc.text('Total Rent Less Commission: ' + 'KES ' + this.formatNumber(this.rentLessCommission), 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.text('Total Due Remitted: ' + 'KES ' + this.formatNumber(this.totalPaid), 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.text('Net Remission: ' + 'KES ' + this.formatNumber(this.netRemmission), 20, textY);
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

            this.allstatements.forEach((statement, index) => {
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
            let fileName = this.property.name + " " + this.formatMonth(new Date()) + ' Rent Statement' + '_Total_Pages_' + currentPage + '.pdf';
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
        generateEmailPDF() {
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
            const headerText = 'Generated on: ' + new Date().toLocaleString() + '\n' + 'Statement for:' + '\n' + this.landlord + '\n' + this.property.name + '\n' + this.landlordPhone + '\n' + this.landlordEmail;
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
            const titleText = (this.property.name + " " + this.currentMonth + ' Rent Statement').toUpperCase();
            const titleFontSize = 16;
            const titleWidth = doc.getStringUnitWidth(titleText) * titleFontSize / doc.internal.scaleFactor;
            const titleX = (doc.internal.pageSize.width - titleWidth) / 2;
            const titleY = imageY + imageHeight + 10;

            doc.setFontSize(titleFontSize);
            doc.setTextColor(44, 62, 80); // Set text color to a dark shade
            doc.text(titleText, titleX, titleY);

            const roundedCommission = Math.round(this.property.commission * 100);
            const commissionTotal = this.propertyCommission / 100 * this.totalRent;
            const netRemissionTotal = Math.round(this.totalPaid - (this.totalAmountPaid + commissionTotal));

            // Add content headers
            doc.setFontSize(14);
            doc.setTextColor(44, 62, 80);
            doc.text('Total Expenses: ' + 'KES ' + this.formatNumber(this.totalAmountPaid), 20, imageY + imageHeight + 35);

            doc.setFontSize(14);
            doc.setTextColor(52, 73, 94); // Set text color to a slightly lighter shade

            let textY = imageY + imageHeight + 20; // Initial y-coordinate for the first text

            doc.text('Total Rent Less Commission: ' + 'KES ' + this.formatNumber(this.rentLessCommission), 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.text('Total Due Remitted: ' + 'KES ' + this.formatNumber(this.totalPaid), 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.text('Net Remission: ' + 'KES ' + this.formatNumber(this.netRemmission), 20, textY);
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

            this.allstatements.forEach((statement, index) => {
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
            
            
            let fileName = this.property.name + " " + this.formatMonth(new Date()) + ' Rent Statement' + '_Total_Pages_' + currentPage + '.pdf';
            
            // Save the PDF as a Blob
            return new Promise((resolve, reject) => {
                try {
                    const pdfBlob = doc.output('blob'); // Generate the PDF as a Blob
                    resolve(pdfBlob); // Return the Blob
                } catch (error) {
                    reject(error);
                }
            });
        },

        async sendMail() {
            // First, generate the invoice content and create a Blob
            const invoiceContent = this.buildInvoiceContent();
            const blob = new Blob([invoiceContent], { type: 'text/html' });
            const file = new File([blob], 'invoice.html', { type: 'text/html' });

            // Generate the PDF and convert it to a File
            const pdfBlob = await this.generateEmailPDF();
            const pdfFile = new File([pdfBlob], 'Rent_Statement.pdf', { type: 'application/pdf' });

            // Check if landlordEmail is provided
            if (!this.landlordEmail) {
                Swal.fire({
                    title: 'Error sending email',
                    text: 'Please ensure ' + this.landlord + ' has a valid email address',
                    icon: 'warning',
                });
                return;
            }

            // Prepare form data to send the email request to the backend
            const formData = new FormData();
            formData.append('email', this.landlordEmail);
            formData.append('subject', 'Invoice & Rent Statement');
            formData.append('message', 'Attached is your invoice and rent statement for ' + this.currentMonth);
            formData.append('invoice', file);
            formData.append('pdfFile', pdfFile);

            try {
                // Make API call to send email
                await axios.post('/api/send-landlordinvoice', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                toast.fire(
                    'To: ' + this.landlordEmail,
                    'Email has been sent successfully.',
                    'success'
                );
            } catch (error) {
                Swal.fire({
                    title: 'Error sending email',
                    text: error.response?.data?.message || error.message,
                    icon: 'warning',
                });
            }
        },

        printReceipt(statement) {
            console.log("alone",statement);
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
            const receiptContent = this.buildReceiptContent();

            // Write the content to the new window
            printWindow.document.write(receiptContent);

            // Close the document stream
            printWindow.document.close();

            // Trigger the print dialog
            printWindow.print();
        },
        buildReceiptContent() {
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
                  <div class="receipt">
                    <div class="receipt-header">
                      <h1>April Properties</h1>
                      <p>${this.contacts.address}</p>
                      <p>Phone: ${this.formatPhoneNumber(this.contacts.phone)} | Email: ${this.contacts.email}</p>
                    </div>
                    <div class="receipt-info">
                      <p><strong>Invoice Number:</strong> ${this.refNo}</p>
                      <p><strong>Receipt Date:</strong> ${new Date().toLocaleString()}</p>
                      <p><strong>Rent Month:</strong> ${this.formatMonth(this.date)}</p>
                      <p><strong>Tenant:</strong> ${this.tenant}</p>
                      <p><strong>Property:</strong> ${this.property.name} - ${this.unitName}</p>
                      <p><strong>Payment Mode:</strong> ${this.payment}</p>
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
                          <td>KES ${this.formatNumber(this.waterBill)}</td>
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
                          <th>Total:</th>
                          <td>KES ${this.formatNumber(this.total)}</td>
                        </tr>
                        <tr>
                          <th>Paid:</th>
                          <td>KES ${this.formatNumber(this.paid)}</td>
                        </tr>
                        <tr>
                          <th>Balance:</th>
                          <td>KES ${this.formatNumber(this.balance)}</td>
                        </tr>
                      </tfoot>
                    </table>
                    <div class="receipt-footer">
                      <p>You were served by ${this.user.first_name} ${this.user.last_name}. Thank you for your payment.</p>
                      <p>This receipt acknowledges the payment received for the above property management services.</p>
                    </div>
                  </div>
                </body>
                </html>
            `;

            return receiptHTML;
        },
        formatMonth(value) {
            if (value) {
                return moment(String(value)).format('MMM YYYY');
            }
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
        getCurrentDate() {
          const now = new Date();
          const day = String(now.getDate()).padStart(2, '0');
          const month = String(now.getMonth() + 1).padStart(2, '0'); // January is 0, so we add 1
          const year = now.getFullYear();
          return `${day}/${month}/${year}`;
        },
        loadLists()
        {
          axios.get('/api/lists').then((response) => {

             this.payments = response.data.lists.payments;
             this.mobileMoney = this.payments[0];
             this.bankMoney = this.payments[1];
             this.contacts = response.data.lists.contacts[0];
             // this.tillMoney = response.data.lists.tillpayment;
             // console.log("pussy", this.tillMoney)
    
             });
        },
        getInvoices() {
             axios.get('/api/propertysettledinvoices/'+this.$route.params.id).then((response) => {
                //settled invoices
             this.statements = response.data.propertymonthsettledinvoices;
             //all invoices (unsettled & vacants too)
             this.allstatements = response.data.propertymonthinvoices;
             this.commercialpropertymonthinvoices = response.data.commercialpropertymonthinvoices;
             this.residentialpropertymonthinvoices = response.data.residentialpropertymonthinvoices;
             console.log("kisumu",this.residentialpropertymonthinvoices);
             
             // Calculate the total amount paid
             setTimeout(() => {
                  $("#AllStatementsTable").DataTable();
              }, 10);
    
             });
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
        getProperty()
        {
          axios.get('/api/pmsproperty/'+ this.$route.params.id).then((response) => {
            this.property = response.data.property;
            this.commission = this.property.landlord.commission;
            this.fixedCommission = this.property.landlord.fixed_commission;
            this.fName = this.property.landlord.first_name;
            this.lName = this.property.landlord.last_name;
            this.landlord = this.fName + " " + this.lName;
            this.landlordPhone = this.property.landlord.phone_no;
            this.landlordAddress = this.property.landlord.address;
            this.landlordEmail = this.property.landlord.email;
            this.unitsNo = this.property.units_no;
            if(this.commission !== null)
            {
              this.propertyCommission = this.commission + ' %';
              this.commercialPropertyAmount = ((this.commission/100) * this.commercialpropertymonthinvoices);
              this.residentialPropertyAmount = ((this.commission/100) * this.residentialpropertymonthinvoices);
              this.totalCommission = ((this.commission/100) * this.totalRent);
              this.rentLessCommission = this.totalRent - this.totalCommission;
            }
            else
            {
              this.propertyCommission = this.fixedCommission;
              this.commercialPropertyAmount = this.commercialpropertymonthinvoices - this.propertyCommission;
              this.residentialPropertyAmount = this.residentialpropertymonthinvoices - this.propertyCommission;
              this.totalCommission = this.propertyCommission;
              this.rentLessCommission = this.totalRent - this.totalCommission;
            }
          }).catch((error) => {
              console.log('error', error)
          })
        },
        getPropertyExpenses()
        {
          axios.get('/api/pmspropertyexpenses/'+ this.$route.params.id).then((response) => {
            this.expenses = response.data.pmspropertyexpenses;
            // this.commission = this.property.landlord.commission;
            // this.fixedCommission = this.property.landlord.fixed_commission;
            this.totalAmountPaid = this.calculateTotalAmountPaid();
            this.netRemmission = this.rentLessCommission - (this.totalAmountPaid);            
            // console.log("2", this.totalAmountPaid)
            // console.log("ruto", this.expenses)
          }).catch((error) => {
              console.log('error', error)
          })
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

          return this.allstatements.reduce((total, statement) => total + (statement[property] || 0), 0);
        },
         updateTime() {
          const now = new Date();
          // Formatting the time to a readable format, e.g. HH:MM:SS
          this.currentTime = now.toLocaleTimeString();
        },
        formatPhoneNumber(number) {
          // Convert number to string and prepend '0'
          const str = '0' + number.toString();
          
          // Use a regular expression to format the number
          const formatted = str.replace(/^(\d{5})(\d{4})$/, '$1-$2');
          
          return formatted;
        }

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
        },
        totalRent()
        {
          return this.calculateTotal('rent');          
        }
      },      
      mounted(){
        this.loadLists();
        this.getInvoices();
        this.getProperty();
        this.getPropertyExpenses();
        this.loadLogo();
        this.propertyId = this.$route.params.id;
        this.currentDate = this.getCurrentDate(); // Set the initial date
        this.user = localStorage.getItem('user');
        this.user = JSON.parse(this.user);
        this.updateTime(); // Set the initial time
        setInterval(this.updateTime, 1000); // Update the time every second
        this.currentMonth = this.getCurrentMonth(); // Set the initial date
        this.updateTime();
        // Update the time every second
        setInterval(this.updateTime, 1000);
        this.totalRent = this.calculateTotalRent();
      }
    }
    </script>
    
    
    <style scoped>
    .active-link {
      background-color: darkgreen;
      border-color: darkgreen;
      color: white; /* Optional: to ensure the text is visible */
    }
    </style>