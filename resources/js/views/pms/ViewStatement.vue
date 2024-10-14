<template>
    <TheMaster>
        <section class="section">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Statement Details</h5>
                            <hr class="mb-4">

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                        <div>Invoice No.</div>
                                        <div><strong>{{refNo}}</strong></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                        <div>Invoice Date</div>
                                        <div v-if="invoice !== null"><strong>{{format_date(invoice.created_at)}}</strong></div>
                                        <div v-else><strong>N/A</strong></div>
                                    </div>
                                </div>
                            </div>                            

                             <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                        <div>Property</div>
                                        <div><strong>{{name}}</strong></div>
                                    </div>
                                </div>
                            </div>

                             <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                        <div>Unit</div>
                                        <div><strong>{{unitName}}</strong></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                        <div>Tenant</div>
                                        <div><strong>{{tenant}}</strong></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                        <div>Phone Number</div>
                                        <div><strong>0{{phoneNumber}}</strong></div>
                                    </div>
                                </div>
                            </div>                           

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                        <div>Details</div>
                                        <div><strong>{{details}}</strong></div>
                                    </div>
                                </div>
                            </div>  

                            <!-- Email Reminder Section -->
                            <div v-if="emailCount > 0" class="row mb-3">
                              <div class="col-lg-12">
                                <div class="d-flex justify-content-between">
                                  <div>
                                    <i class="fas fa-envelope"></i> <!-- FontAwesome Email Icon -->
                                    View Email Reminder(s)
                                  </div>
                                  <div><strong>{{emailCount}}</strong></div>
                                </div>
                              </div>
                            </div>

                            <!-- WhatsApp Reminder Section -->
                            <div v-if="whatsappCount > 0" class="row mb-3">
                              <div class="col-lg-12">
                                <div class="d-flex justify-content-between">
                                  <div>
                                    <i class="fab fa-whatsapp"></i> <!-- FontAwesome WhatsApp Icon -->
                                    View WhatsApp Reminder(s)
                                  </div>
                                  <div><strong>{{whatsappCount}}</strong></div>
                                </div>
                              </div>
                            </div>

                            <!-- SMS Reminder Section -->
                            <div v-if="smsCount > 0" class="row mb-3">
                              <div class="col-lg-12">
                                <div class="d-flex justify-content-between">
                                  <div>
                                    <i class="fas fa-sms"></i> <!-- FontAwesome SMS Icon -->
                                    View SMS Reminder(s)
                                  </div>
                                  <div><strong>{{smsCount}}</strong></div>
                                </div>
                              </div>
                            </div>
                             

                            <div class="row mt-4">
                                <div class="col-sm-6">
                                    <!-- <button @click.prevent="editStatement()" v-if="user.role_id == 1" style="background-color: orange; border-color: orange;" class="btn btn-dark w-100">Edit</button> -->
                                </div>
                                <div class="col-sm-6 text-end">
                                    <!-- Additional buttons can be added here if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card px-2">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Invoice</h5>
                            <hr class="mb-4">

                            <form class="row g-3 needs-validation" novalidate method="post" autocomplete="off" @submit.prevent="submit">
                                <div class="row mb-3"></div>

                                <!-- Default Table -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Rent</th>
                                            <th scope="col">Garbage</th>
                                            <th scope="col">Water</th>
                                            <th scope="col">Security</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{formatNumber(unitRent)}}</td>
                                            <td>{{formatNumber(unitGarbageFee)}}</td>
                                            <td v-if="waterBill !== null">{{formatNumber(waterBill)}}</td>
                                            <td v-else>N/A</td>
                                            <td>{{formatNumber(unitSecurityFee)}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Status</th>
                                            <td></td>
                                            <td></td>
                                            <td v-if="status == 1" scope="row"><span style="color: green;">Settled</span></td>
                                            <td v-else scope="row"><span style="color: red;">Unsettled</span></td>
                                        </tr>
                                                                                                                       
                                        <tr>
                                            <th scope="row">Due</th>
                                            <td></td>
                                            <td></td>
                                            <td><strong>KES. {{formatNumber(total)}}</strong></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Paid</th>
                                            <td></td>
                                            <td></td>
                                            <td>{{formatNumber(paid)}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Balance</th>
                                            <td></td>
                                            <td></td>
                                            <td>{{formatNumber(balance)}}</td>
                                        </tr> 
                                    </tbody>
                                </table>
                                <!-- End Default Table Example -->

                                <!-- Email Receipts Section -->
                                <div v-if="emailReceiptCount > 0" class="row mb-3">
                                  <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                      <div @click="viewEmailReceipts" style="cursor: pointer;">
                                        <i class="fas fa-envelope"></i> <!-- FontAwesome Email Icon -->
                                        View Email Receipt(s) 
                                      </div>
                                      <div><strong>{{emailReceiptCount}}</strong></div>
                                    </div>
                                  </div>
                                </div>

                                <!-- WhatsApp Receipts Section -->
                                <div v-if="whatsappReceiptCount > 0" class="row mb-3">
                                  <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                      <div @click="viewWhatsAppReceipts" style="cursor: pointer;">
                                        <i class="fab fa-whatsapp"></i> <!-- FontAwesome WhatsApp Icon -->
                                        View WhatsApp Receipt(s) 
                                      </div>
                                      <div><strong>{{whatsappReceiptCount}}</strong></div>
                                    </div>
                                  </div>
                                </div>



                                <div class="row mt-4">
                                    <div class="col-sm-6">
                                        <button @click.prevent="cancel()" class="btn btn-dark w-100">Back</button>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <button @click.prevent="settleTenant()" type="submit" v-if="status == 0 && waterBill !== null && settleInvoicePermission" class="btn btn-primary w-100" style="background-color: darkgreen; border-color: darkgreen;">Settle</button>
                                        <button @click.prevent="invoiceTenant()" type="submit" v-else-if="status == 0 && waterBill == null && invoiceTenantPermission" class="btn btn-primary w-100" style="background-color: darkgreen; border-color: darkgreen;">Invoice</button>
                                        <button @click="printReceipt" v-else class="btn btn-primary w-100" style="background-color: darkgreen; border-color: darkgreen;">Print Receipt</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </TheMaster>
</template>

<script>
import TheMaster from '@/components/dashboard/TheMaster.vue'
import axios from 'axios';
import Swal from 'sweetalert2';
import moment from 'moment';

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

export default {
    data() {
        return {
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
            emailCount: '',
            whatsappCount: '',
            smsCount: '',
            whatsappReceiptCount: '',
            emailReceiptCount: '',
            total: '',
            statementId: '',
            waterBill: '',
            unitRent: '',
            unitSecurityFee: '',
            unitGarbageFee: '',
            unitName: '',
            invoice: '',
            user: [],
            invoiceTenantPermission: '',
            settleInvoicePermission: ''
        }
    },
    components: {
        TheMaster,
    },
    methods: {
        viewEmailReceipts() {
            // Logic to view email receipts, e.g., open a modal or redirect to a new page
            console.log("Viewing email receipts");
            // You can use router navigation or show a modal here
            this.$router.push('/email-receipts'); // Example of navigation
          },
          viewWhatsAppReceipts() {
            // Logic to view WhatsApp receipts, e.g., open a modal or redirect to a new page
            console.log("Viewing WhatsApp receipts");
            // You can use router navigation or show a modal here
            this.$router.push('/whatsapp-receipts'); // Example of navigation
          },
        getStatement() {
            axios.get('/api/pmsstatement/' + this.$route.params.id).then((response) => {
                this.statement = response.data.pmsstatement[0]
                this.name = this.statement.property.name;
                this.firstName = this.statement.tenant.first_name;
                this.lastName = this.statement.tenant.last_name;
                this.tenant = this.firstName + " " + this.lastName;
                this.phoneNumber = this.statement.tenant.phone_number;
                this.unitNumber = this.statement.tenant.pms_unit_id;
                this.tenantId = this.statement.pms_tenant_id;
                this.getUnit(this.unitNumber);
                this.refNo = this.statement.ref_no;
                this.details = this.statement.details;
                this.date = this.statement.created_at;
                this.status = this.statement.status;
                this.paid = this.statement.paid;
                this.balance = this.statement.balance;
                this.emailCount = this.statement.email_count;
                this.whatsappCount = this.statement.whatsapp_count;
                this.smsCount = this.statement.sms_count;
                this.whatsappReceiptCount = this.statement.whatsapp_receipt_count;
                this.emailReceiptCount = this.statement.email_receipt_count;
                this.total = this.statement.total;
                this.payment = this.statement.payment_method;
                this.statementId = this.statement.id;
                this.waterBill = this.statement.water_bill;
                console.log("statement", this.statement)
            })
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
        getInvoiceDate()
        {
          axios.get('/api/pmsinvoicedatethrostatement/'+ this.$route.params.id)
          .then((response) => {
            this.invoice = response.data.invoice;
            // this.invoiceDate = this.invoice.created_at;
            console.log("date", response)
          })
          .catch((error) => {
                    console.error("Error fetching unit:", error);            
          })
        },
        getUserPermissions(id) {
          axios.get('api/userpermissions/' + id)
            .then((response) => {
              this.permissions = response.data.permissions;
              console.log(this.permissions)

              // Define the permission id you want to check for
              const requiredEditPermissionId = 4;
              const requiredSettlePermissionId = 5;
              const requiredStatus = 1;

              // Check if the user has the required permissions
              const hasEditPermission = this.permissions.some(permission => 
                permission.permission_id === requiredEditPermissionId && permission.status === requiredStatus);

              const hasSettlePermission = this.permissions.some(permission => 
                permission.permission_id === requiredSettlePermissionId && permission.status === requiredStatus);

              if (hasEditPermission) {
                // User has the required permission, allow them to view things
                this.invoiceTenantPermission = true;
                console.log(`User has permission: ${this.invoiceTenantPermission}`);
              } else {
                // User does not have the required permission
                this.invoiceTenantPermission = false;
                console.log('User does not have the required permission');
              }

              if (hasSettlePermission) {
                // User has the required permission, allow them to view things
                this.settleInvoicePermission = true;
                console.log(`User has permission: ${this.settleInvoicePermission}`);
              } else {
                // User does not have the required permission
                this.settleInvoicePermission = false;
                console.log('User does not have the required permission');
              }
              })
              .catch(error => {
                console.error('Error fetching permissions:', error);
              });
        },
        cancel() {
          this.$router.go(-1);
        },
        viewInvoice()
        {
          this.$router.push('/invoicestatement/'+this.statementId)
        },
        editStatement() {
            this.$router.push('/editstatement/' + this.statementId)
        },
        settleTenant() {
            this.$router.push({
                name: 'settlestatement', // Assuming you have named routes
                params: {
                    id: this.statementId,
                    tenantId: this.tenantId
                }
            });
        },
        invoiceTenant() {
            this.$router.push('/invoicestatement/' + this.statementId)
        },
        submit() {
            let self = this;  // Store the reference to this
            let payload = {
                // mpesa_code: this.form.mpesa_code,
                // payment_method: this.form.payment_method,
                paid: this.paid,
                balance: this.balance
            };

            axios.put("/api/pmssettlestatement/" + this.$route.params.id, payload)
                .then(function (response) {
                    console.log(response);
                    // self.step = 1;
                    toast.fire(
                        'Success!',
                        'Invoice updated!',
                        'success'
                    );
                })
                .catch(function (error) {
                    console.log(error);
                    // Swal.fire(
                    //    'error!',
                    //    // phone_error + id_error + pass_number,
                    //    'error'
                    // )
                });

            this.$router.push('/settledinvoices');
        },
        printReceipt() {
            // this.submit();
            this.$router.push('/settledinvoices')

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
        buildReceiptContent(refNo) {
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
                      <p>Kakamega-Webuye Rd, ACK Building</p>
                      <p>Phone: (0720) 020-401 | Email: propertapril@gmail.com</p>
                    </div>
                    <div class="receipt-info">
                      <p><strong>Invoice Number:</strong> ${this.refNo}</p>
                      <p><strong>Receipt Date:</strong> ${this.formattedTodayDate}</p>
                      <p><strong>Details:</strong> ${this.details}</p>
                      <p><strong>Tenant:</strong> ${this.tenant}</p>
                      <p><strong>Property:</strong> ${this.name}</p>
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
                          <td>Garbage Collection Fee</td>
                          <td>KES ${this.formatNumber(this.unitGarbageFee)}</td>
                        </tr>
                        <tr>
                          <td>Security Fee</td>
                          <td>KES ${this.formatNumber(this.unitSecurityFee)}</td>
                        </tr>
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
         format_date(value){
          if(value){
            return moment(String(value)).format('lll');
          }
        }, 
        formatNumber(value) {
            // Use the toLocaleString method to format the number with commas and decimal places
            return value.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },
    },
    mounted() {
        this.getStatement();
        this.getInvoiceDate();
        this.user = localStorage.getItem('user');
        this.user = JSON.parse(this.user);
        this.userId = this.user.id;
        this.getUserPermissions(this.userId);
        // Get the current date
        const todayDate = new Date();

        // Convert to desired format dd/mm/yy
        this.formattedTodayDate = todayDate.toLocaleDateString('en-GB', {
          day: '2-digit',
          month: '2-digit',
          year: '2-digit'
        });
    }
}
</script>

<style scoped>
.section {
    padding: 20px;
}

.card {
    border-radius: 10px;
}

.card-title {
    font-size: 1.25rem;
}

.label {
    font-weight: bold;
    color: #333;
}

.row.mb-3 {
    margin-bottom: 1rem;
}

.row.mt-4 {
    margin-top: 1rem;
}

.text-end {
    text-align: right;
}
</style>
