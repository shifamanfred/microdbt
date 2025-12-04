<?php $loan_schedule_dialog = true; ?>

<div aria-hidden="true" aria-labelledby="loanScheduleModal" role="dialog" tabindex="-1" id="loan_schedule_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Record Amount</h4>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 mt">

          <div class="content-panel">
            <h4><i class="fa fa-angle-right"></i> Total Loan</h4>
            <table class="table">
              <thead>
                <tr>
                  <th>Principle</th>
                  <th> + Interest</th>
                  <th> + Charges</th>
                  <th>Loan Repayable</th>
                </tr>
              </thead>
              <tbody>
                <tr id="loan_basis">
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>


          <div class="content-panel">
            <h4><i class="fa fa-angle-right"></i> Payment Schedule</h4><hr>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Due Date</th>
                  <th>EMI</th>
                  <th>Penalty Fee</th>
                  <th>Principle Amount</th>
                  <th>Interest</th>
                  <th>Balance</th>
                </tr>
              </thead>
              <tbody id="payment_schedule">
                <!-- javascript CONTENT -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer centered">
        <button data-dismiss="modal" class="btn btn-theme04" type="button">Cancel</button>
        <button class="btn btn-theme03" type="submit">Record</button>
      </div>
    </div>
  </div>
</div>
