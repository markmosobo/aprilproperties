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
                            <router-link :to="`/pmstenantstatements/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
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
                            <router-link :to="`/pmsyeartenantstatements/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
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
                            <router-link :to="`/pmsalltenantstatements/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
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
                      <h5 class="card-title">{{tenant.first_name}} {{tenant.last_name}}'s Invoices <span>| This Month</span></h5>
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
                              <span v-if="statement.status == 1" class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Settled</span>
                              <span v-else class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Not Settled</span>
                            </td>
                            <td>
                              <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm btn-primary rounded-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                  <a @click="navigateTo('/viewinvoice/'+statement.statement_id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a> 
                                  <a @click="navigateTo('/viewinvoice/'+statement.statement_id )" class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>                                                                             
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
          paymentMethod: ''
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
         invoiceTenant(id){
            this.$router.replace('/invoicestatement/'+id)
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
        getTenantStatements() {
             axios.get('/api/pmstenantinvoices/'+this.$route.params.id).then((response) => {
             this.statements = response.data.pmstenantinvoices;
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
                console.log(this.logoBase64)
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
                  </div>
                </div>
                <div class="receipt-info">
                  <p><strong>Invoice For:</strong></p>
                  <p><strong></strong> ${this.tenantName}</p>
                  <p><strong></strong> ${this.tenantProperty} - ${this.tenantUnit}</p>
                  <p><strong></strong> ${this.currentMonth}</p>
                  <p><strong></strong>  ${new Date().toLocaleString()}</p>
                  
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
                <div class="receipt-footer">
                  <p>PDF Generated on ${new Date().toLocaleDateString()}</p>
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
          XLSX.utils.book_append_sheet(workbook, worksheet, "SETTLED INVOICES");

          // Customize the filename with a timestamp
          const timestamp = new Date().toISOString().slice(0, 19).replace(/-/g, "").replace(/:/g, "").replace(/T/g, "_");
          const filename = `SETTLED_INVOICES_${timestamp}.xlsx`;
          
          XLSX.writeFile(workbook, filename);
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
            const titleText = (this.tenantName+"'s "+this.formatMonth(new Date)+' Rent Statement').toUpperCase();
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

            // const roundedCommission = Math.round(this.property.commission * 100);
            // const commissionTotal = roundedCommission/100*this.totalPaid;

            // const netRemissionTotal = Math.round(this.totalPaid - (this.totalAmountPaid + commissionTotal));

            // Add content headers
            // doc.setFontSize(14);
            // doc.setTextColor(44, 62, 80);
            // doc.text(roundedCommission +'% Commission: '+ 'KES ' +this.formatNumber(commissionTotal), 20, imageY + imageHeight + 35);



            doc.setFontSize(14);
            doc.setTextColor(52, 73, 94); // Set text color to a slightly lighter shade

            let textY = imageY + imageHeight + 20; // Initial y-coordinate for the first text

            doc.text('Total Rent Due: ' + 'KES ' + this.formatNumber(this.totalDue), 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.text('Total Rent Paid: '+ 'KES ' +this.formatNumber(this.totalPaid), 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.text('Total Balance: ' + 'KES ' + this.formatNumber(this.totalBalance) , 20, textY);
            textY += 10; // Increment y-coordinate for the next text

            doc.setFontSize(12);
            doc.setTextColor(0);

            let headerYPos = imageY + imageHeight + 45;
            let cellHeight = 10;
            let cellPadding = 2;
            let lineHeight = 5;
            let columnWidths = [60, 30, 70, 30, 30, 30];
            let columnHeaders = ['Invoiced On', 'Status', 'Detail', 'Due', 'Paid', 'Bal'];

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
                            let statusText = statement.status == 1 ? 'Settled' : 'Not Settled';
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
            // let totalPages = this.addExpensesToPDF(this.expenses, doc);
            // Save the PDF
            let fileName = this.tenantName +"'s ' "+ this.formatMonth(new Date)+' Rent Statement' + '_Page_' + currentPage + '.pdf';
            // let fileName = this.property.name+" "+this.formatMonth(this.property.created_at)+' Rent Statement' + '_Total_Pages_' + totalPages + '.pdf';

            doc.save(fileName);
      },
      },
      components : {
          TheMaster,
      },
      mounted(){
        this.getTenant();
        this.getTenantStatements();
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
        }
      },
    }
    </script>
    
    
    