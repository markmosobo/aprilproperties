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
                            <router-link :to="`/pmsmonthtenantstatements/${tenantId}`" custom v-slot="{ href, navigate, isActive }">
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
                      <h5 class="card-title">{{tenant.first_name}} {{tenant.last_name}}'s Statement <span>| All Time</span></h5>
                      <p class="card-text">
                   
                          <button @click="generatePDF">Generate PDF</button>
            
                      </p>
    
                      <table id="AllStatementsTable" class="table table-borderless">
                        <thead>
                          <tr>
                            <th scope="col">Invoice</th>
                            <th scope="col">Property</th>                            
                            <th scope="col">Detail</th>
                            <th scope="col">Total</th>
                            <th scope="col">Paid</th>
                            <th scope="col">Bal</th>
                            <th scope="col">Transaction On</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="statement in statements" :key="statement.id">
                            <td>{{statement.ref_no}}</td>
                            <td>{{statement.details}}</td>
                            <td>{{statement.property.name}}</td>                            
                            <td>{{formatNumber(statement.total)}}</td>
                            <td>{{formatNumber(statement.paid)}}</td>
                            <td>{{formatNumber(statement.balance)}}</td>
                            <td>{{format_date(statement.updated_at)}}</td>
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
                                  <a @click="navigateTo('/viewstatement/'+statement.id )" class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>                                            
                                  <a v-if="statement.status == 0 && statement.water_bill == null" @click="invoiceTenant(statement.id)" class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Invoice</a>
                                  <a v-if="statement.status == 0" @click="settleTenant(statement.id, statement.pms_tenant_id)" class="dropdown-item" href="#"><i class="ri-check-fill mr-2"></i>Settle</a>
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
          tenantId: this.$route.params.id
        }
      },
      methods: {
        getTenant()
        {
          axios.get('/api/pmstenant/'+ this.$route.params.id).then((response) => {
            this.tenant = response.data.tenant[0] 
            console.log("dat", this.tenant)
          }).catch(() => {
              console.log('error')
          })
        },
        navigateTo(location){
            this.$router.push(location)
        },
         invoiceTenant(id){
            this.$router.push('invoicestatement/'+id)
        },
        settleTenant(id){
            this.$router.push('/settlestatement/'+id)
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
            return moment(String(value)).format('lll')
          }
        }, 
        formatMonth(dateString) {
          // Parse the date string using Moment.js and format it
           return moment(dateString).format('MMM YYYY');
        }, 
        calculateTotal(property) {
          // Function to calculate total for Total, Paid, and Bal columns

          return this.statements.reduce((total, statement) => total + (statement[property] || 0), 0);
        },      
        getTenantStatements() {
             axios.get('/api/pmsalltenantstatements/'+this.$route.params.id).then((response) => {
             this.statements = response.data.pmsalltenantstatements;
             console.log("props", response)
             setTimeout(() => {
                  $("#AllStatementsTable").DataTable();
              }, 10);
    
             });
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
            const tenantName = this.tenant.first_name + " " + this.tenant.last_name;
            const headerText = 'Generated on: ' + new Date().toLocaleString()+'\n'+'Tenant: '+tenantName+'\n'+'ID Number: '+this.tenant.id_number + '\n'+'Phone: '+this.tenant.phone_number+'\n'+this.tenant.property.name+'\n'+this.tenant.unit.unit_number;
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
            const titleText = (tenantName+"'s "+' Full Rent Statement').toUpperCase();
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
            let fileName = tenantName +"'s "+' Full Rent Statement' + '_Page_' + currentPage + '.pdf';
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
        }
      },
    }
    </script>
    
    
    