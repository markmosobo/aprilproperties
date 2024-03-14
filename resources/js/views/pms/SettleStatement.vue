<template>
    <TheMaster>

    <section class="section">
          <div class="row">
            <div class="col-lg-6">

              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Statement Details</h5>

                  <div class="row">
                    <div class="col-lg-12 col-md-4 label "><strong>{{name}}</strong></div>
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
                </div>

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
              </div>

            </div>

            <div class="col-lg-6">

            <div class="card px-2">
                    <div class="card-body">
                    <h5 class="card-title">Settle Invoice</h5>
                
                    <form
                    class="row g-3 needs-validation"
                    novalidate=""
                    method="post"
                    autocomplete="off"
                    >
                    <div class="row mb-3"></div>
                    <div class="form-group row">
                      <input
                        type="hidden"
                        id="user_id"
                        name="user_id"
                        value="1"
                        class="form-control"
                      />
                      <div class="col-sm-12">
                        <label for="validationCustom04" class="form-label"
                          >Please select payment method:</label
                        >
                        <div class="col-sm-10">
                            <select name="category" v-model="form.payment_method" class="form-select" id="">
                                <option value="0" disabled>Select Payment</option>
                                <option value="Mpesa" selected>MPESA (Till Number)</option>
                                <option value="Cash">CASH</option>
                                <option value="Bank">BANK</option>

                            </select>
                          <div class="invalid-feedback">Please enter flight number!</div>
                        </div>
                      </div>
                    </div>
             
                    <div class="row mb-3"></div>
                    <div v-if="form.payment_method === 'Mpesa'" class="form-group row">
                      <div class="col-sm-12">
                        <label for="inputPassword" class="form-label">Please provide MPESA code</label>
                        <div class="col-sm-10">
                          <input
                            type="decimal"
                            placeholder="Transaction Code"
                            v-model="form.mpesa_code"
                            id="mpesa_code"
                            name="mpesa_code"
                            class="form-control"
                            required=""
                          />
                          <div class="invalid-feedback">Please enter address!</div>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3"></div>

                    <div class="col-md-6">
                    <label for="inputEmail5" class="form-label">Amount Paid</label>
                    <input type="number" v-model="form.cash" class="form-control" id="inputEmail5">
                    </div>
                    <div class="col-md-6">
                    <label for="inputPassword5" class="form-label">Balance</label><br>
                    
                     <h6>{{payableAmount}}</h6>
                    </div>        
                    <div class="row mb-3"></div>
                    <div class="col-lg-12 felx mt-4 row">
                        <div class="col-sm-6 col-lg-6">
                        <button @click.prevent="cancel()" class="btn btn-dark">Cancel</button>
                        </div>
                       <div class="col-sm-6 col-lg-6 text-end">
                        <button @click.prevent="settleReceipt" type="submit" v-if="status == 0 && paid>0" class="btn btn-primary">Print Receipt</button>
                        <button @click="printReceipt" v-else class="btn btn-primary">Print Receipt</button>
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
            isAmountValid: true,

            form:
            {
              payment_method: '',
              cash: '',
              mpesa_code: '',
              balance: ''
            }
        }
    },
    components: {
      TheMaster,
    }, 
    methods:
    {
      settleReceipt() {
        this.settleTenant();
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


      printReceipt() {
        this.submit();
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

      buildReceiptContent() {
        // Build the HTML content for the receipt
        const receiptHTML = `
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>INGO PROPERTIES</title>
          <style>
            body {
              font-family: monospace;
              font-size: 12px;
              margin: 0;
            }
            table, th, td {
              border-collapse: collapse;
            }
            th, td {
              padding: 5px;
              text-align: left;
            }
            .header {
              text-align: center;
            }
            .footer {
              text-align: right;
            }
          </style>
        </head>
        <body>
          <div class="header">
            <h1>INGO PROPERTIES</h1>
            <p>P.O. BOX 1716-50100 KAKAMEGA Opp. Kenya Power Rd.</p>
            <p>Mob: 0722 844 910</p>
          </div>
          <div>
            <p>VAT: Barware - CHED</p>
            <p>WAT NO. 0161493R</p>
            <p>PIN: A0146635900</p>
            <p>Tel: 0769 08207</p>
          </div>
          <div class="header">
            <h3>FISCAL RECEIPT</h3>
            <h3>ORIGINAL</h3>
          </div>
          <table>
            <tr>
              <th>QTY</th>
              <th>Partic</th>
              <th>Invoice Nr:</th>
            </tr>
            <tr v-for="(item) in cart" :key="productId">
              <td>0001</td>
              <td>Operator 01</td>
              <td>000000000001196</td>
            </tr>
            <tr>
              <td>A</td>
              <td>00001 Art. 00001</td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td>Sum</td>
              <td>1.000 pcs X 40500.00</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>700 7000</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>40500.00 A</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>1350 13500</td>
            </tr>
            <tr>
              <td></td>
              <td>TOTAL</td>
              <td>40500.00</td>
            </tr>
            <tr>
              <td></td>
              <td>TOTAL A-16.00%</td>
              <td>40500.00</td>
            </tr>
            <tr>
              <td></td>
              <td>TOTAL TAX A</td>
              <td>5586.21</td>
            </tr>
            <tr>
              <td></td>
              <td>TUTAL TAX</td>
              <td>5586.21</td>
            </tr>
            <tr>
              <td></td>
              <td>CASH</td>
              <td>40500.00</td>
            </tr>
            <tr>
              <td></td>
              <td>ITEMS NUMBER</td>
              <td>1</td>
            </tr>
          </table>
          <div class="footer">
            <p>Printed on: ${new Date().toLocaleString()}</p>
            <p>CU Serial No: FT ANY LIAB</p>
            <p>CU Invoice N:0110691570000001198</p>
            <p>EO&E No 4172</p>
          </div>
        </body>
        </html>
        `;

        return receiptHTML;
      },      
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
              this.refNo = this.statement.ref_no;
              this.details = this.statement.details;
              this.date = this.statement.created_at;
              this.status = this.statement.status;
              this.paid = this.statement.paid;
              this.balance = this.statement.balance;
              this.total = this.statement.total;
              console.log("statement", this.statement)
          })
      },
      getUnit()
      {
        axios.get('/api/pmsunit/'+parseInt(this.unitNumber)).then((response) => {
          console.log("unit", response)
        })
      },
      cancel()
      {
        this.$router.push('/statements')
      },
      settleTenant()
      {
       let self = this;  // Store the reference to this
       let payload = {
          mpesa_code: this.form.mpesa_code,
          payment_method: this.form.payment_method,
          paid: this.form.cash+this.paid,
          balance: this.payableAmount
       };

       axios.put("/api/pmsstatement/" + this.$route.params.id, payload)
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

       this.$router.push('/statements')        
      },      
      submit() {
       let self = this;  // Store the reference to this
       let payload = {
          mpesa_code: this.form.mpesa_code,
          payment_method: this.form.payment_method,
          paid: this.form.cash,
          balance: this.payableAmount
       };

       axios.put("/api/pmsstatement/" + this.$route.params.id, payload)
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
      this.getUnit();
    },
    computed: {
        payableAmount() {
          if (this.paid > 0) {
            return this.balance - this.form.cash;
          }
          else
          {
             return this.total - this.form.cash; // Multiply inputValue by 2 (change this multiplier as needed)
          }
       
        },
    },
}
</script>