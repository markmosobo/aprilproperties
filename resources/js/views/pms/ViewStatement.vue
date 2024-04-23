<template>
    <TheMaster>

    <section class="section">
          <div class="row">
            <div class="col-lg-6">

              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Statement Details</h5>

                  <div class="row">
                    <div class="col-lg-6 col-md-4 label "><strong>{{name}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">{{form.first_name}} {{form.last_name}}</div> -->
                  </div>

                  <div class="row">
                    <div class="col-lg-12 col-md-4 label"><strong>0{{phoneNumber}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">(254) {{form.phone}}</div> -->
                  </div>

                  <div class="row">
                    <div class="col-lg-12 col-md-4 label"><strong>{{tenant}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">{{form.email}}</div> -->
                  </div>
                  <div class="row">
                    <div class="col-lg-12 col-md-4 label"><strong>Ref No: {{refNo}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">{{refNo}}</div> -->
                  </div> 
                  <div class="row">
                    <div class="col-lg-12 col-md-4 label"><strong>{{details}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">{{refNo}}</div> -->
                  </div>                   
                  <div class="row mb-3"></div>
                  <div class="col-lg-12 felx mt-4 row">
                      <div class="col-sm-6 col-lg-6">
                      <button @click.prevent="editStatement()" class="btn btn-dark">Edit</button>
                      </div>
                      <div class="col-sm-6 col-lg-6 text-end">
                      <!-- <button @click="settleTenant()" class="btn btn-primary">Settle</button> -->
                      </div>
                  </div>                                   
                </div>
              </div>

            </div>

            <div class="col-lg-6">

            <div class="card px-2">
                    <div class="card-body">
                    <h5 class="card-title">Invoice</h5>
                
                    <form
                    class="row g-3 needs-validation"
                    novalidate=""
                    method="post"
                    autocomplete="off"
                    @submit.prevent="submit()"
                    >
                    <div class="row mb-3"></div>
                    <!-- Default Table -->
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Status</th>
                          <th scope="col">Paid</th>
                          <th scope="col">Reference</th>
                          <th scope="col">Balance</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td v-if="status == 1" scope="row"><span style="color: green;">Paid</span></td>
                          <td v-else scope="row"><span style="color: red;">Unpaid</span></td>
                          <td>{{formatNumber(paid)}}</td>
                          <td>{{refNo}}</td>
                          <td>{{formatNumber(balance)}}</td>
                        </tr>
                        <tr>
                          <th scope="row">Rate</th>
                          <td></td>
                          <td></td>
                          <td>KES. {{formatNumber(total)}}</td>
                        </tr> 
                      </tbody>
                    </table>
                    <!-- End Default Table Example -->       
                    <div class="row mb-3"></div>
                    <div class="col-lg-12 felx mt-4 row">
                        <div class="col-sm-6 col-lg-6">
                        <button @click.prevent="cancel()" class="btn btn-dark">Cancel</button>
                        </div>
                        <div class="col-sm-6 col-lg-6 text-end">
                        <button @click.prevent="settleTenant()" type="submit" v-if="status == 0" class="btn btn-primary" style="background-color: darkgreen; border-color: darkgreen;">Settle</button>
                        <button @click="printReceipt" v-else class="btn btn-primary" style="background-color: darkgreen; border-color: darkgreen;">Print Receipt</button>
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
export default{
    data(){
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
            total: '',
            statementId: '',
            user: []
        }
    },
    components: {
      TheMaster,
    }, 
    methods:
    {
      getStatement()
      {
          axios.get('/api/pmsstatement/'+this.$route.params.id).then((response) => {
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
              this.total = this.statement.total;
              this.payment = this.statement.payment_method;
              this.statementId = this.statement.id;
              console.log("statement", this.statement)
          })
      },
      getUnit(unitNumber) {
          axios.get('/api/pmsunit/' + parseInt(unitNumber))
              .then((response) => {
                this.unit = response.data.unit[0];
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

      cancel()
      {
        this.$router.push('/statements')
      },
      editStatement()
      {
        this.$router.push('/editstatement/'+this.statementId)
      },
      settleTenant()
      {
         this.$router.push({ 
            name: 'settlestatement', // Assuming you have named routes
            params: { 
              id: this.statementId,
              tenantId: this.tenantId
            } 
          });
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

       this.$router.push('/statements');
      },
      printReceipt() {
        // this.submit();
        this.$router.push('/statements')

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
              <p><strong>Receipt Date:</strong> ${new Date().toLocaleString()}</p>
              <p><strong>Rent Month:</strong> ${this.formatMonth(this.date)}</p>
              <p><strong>Tenant:</strong> ${this.tenant}</p>
              <p><strong>Property:</strong> ${this.name} - ${this.unitName}</p>
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
              <p>You were served by ${this.user.first_name} ${this.user.last_name}.Thank you for your payment.</p>
              <p>This receipt acknowledges the payment received for the above property management services.</p>
            </div>
          </div>
        </body>
        </html>


        `;

        return receiptHTML;
      },
      formatMonth(value){
          if(value){
            return moment(String(value)).format('MMM YYYY');
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
    mounted()
    {
      this.getStatement();
      this.user = JSON.parse(localStorage.getItem('user'));

    }
}
</script>