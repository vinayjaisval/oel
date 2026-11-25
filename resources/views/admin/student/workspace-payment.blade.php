{{-- payment  --}}
<div class="offcanvas offcanvas-end border-0 paymentss-container workspace-payment-drawer" tabindex="-1" id="gmat" aria-label="Payments">
    <div class="sidebar-headerset paymentss-header">
        <div class="sidebar-headersets">
            <h5>Payments</h5>
        </div>
        <div class="sidebar-headerclose">
            <a data-bs-dismiss="offcanvas" aria-label="Close">
                <img src="{{asset('assets/img/close.png')}}" alt="Close Icon">
            </a>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="responseMessage"></div>
        <div class="row">
            <div class="card-stretch-full">
                <div class="row ">
                    <form class="row payment-form-payy" id="score-data">

                        <div class="col-12">
                            <div class="form-floating input-group-payy">
                                <select class="form-control form-select-payy" name="selected_university" id="selected_university"  placeholder="Type" required>
                                    <option value="">--Select University -</option>
                                    
                                </select>
                                <label for="selected_university" class="form-label">Select University</label>
                                <span class="text-danger error-selected-program"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating input-group-payy">
                                <select class="form-control form-select-payy " name="selected_program" id="selected_program" placeholder="Type" required onchange="getappfee(this.value)">
                                    <option value="">--Select Program -</option>
                                </select>
                                <label for="selected_program" class="form-label">Select Program</label>
                                <span class="text-danger error-selected-program"></span>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-floating input-group-payy">
                                <select class="form-control form-select-payy " name="master_service" id="usr-fees_type" placeholder="Type" required onchange="getSubService(this.value)">
                                    <option value="">--Select Master Service--</option>
                                    @foreach ($master_service as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label for="usr-fees_type" class="form-label">Master Service</label>
                                <span class="text-danger error-master-service"></span>
                            </div>
                        </div>
                        <!-- <div class="col-12">
                            <div class="form-floating input-group-payy">
                                <select class="form-control form-select-payy " name="sub_service[]" multiple id="usr-sub_service" placeholder="Type" required>
                                    <option value="">--Select Sub Service--</option>
                                </select>
                                <label for="usr-sub_service" class="form-label">Sub Service</label>
                                <span class="text-danger error-sub-service"></span>
                            </div>
                        </div> -->

                        <div class="col-12">
                            <div class="form-floating input-group-payy">
                                <div class="sub-service-wrapper-payy">
                                    <div class="custom-dropdown position-relative">
                                        <!-- <label for="sub-service-input" class="payment-header-payy">Sub Services</label> -->
                                        <input type="text" class="form-control form-select-payy" id="sub-service-input" readonly placeholder="Select Sub Services ">
                                        <div class="dropdown-menu menu w-100 p-2">
                                            <div class="options-list1" id="sub-service-options"></div>
                                        </div>
                                        <select class="d-none" name="sub_service[]" multiple id="usr-sub_service" required></select>

                                    </div>
                                    <div class="selected-options-payy mt-2"></div>
                                </div>
                                <span class="text-danger error-sub-service"></span>
                            </div>
                        </div>
                        <input type="hidden" id="application_fee">
                        @php
                        $users = Auth::user();
                        @endphp
                        @if($users->hasRole('Application Punching')|| $users->hasRole('Administrator'))
                        <div class="col-12">
                            <div class="form-floating input-group-payy">
                                <input id="usr-amount" name="amount" type="number" readonly class="form-control" placeholder="Number" autocomplete="amount" required>
                                <label for="usr-amount" class="form-label">Amount</label>
                                <span class="text-danger error-amount"></span>
                            </div>
                        </div>
                        @else
                        <div class="col-12">
                            <div class="form-floating input-group-payy">
                                <input id="usr-amount" name="amount" type="number" readonly class="form-control" placeholder="Number" autocomplete="amount" required>
                                <label for="usr-amount" class="form-label">Amount</label>
                                <span class="text-danger error-amount"></span>
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="form-floating input-group-payy">
                                <select class="form-control form-select-payy" name="is_discount" id="is_discount" onchange="discountField()">
                                    <option value="">--Select Discount--</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <label for="is_discount" class="form-label">Discount</label>
                            </div>
                        </div>
                        <div class="col-12 discount-field" style="display: none;">
                            <div class="form-floating input-group-payy">
                                <input id="usr_discount" name="discount" type="number" class="form-control" placeholder="Number" autocomplete="discount">
                                <label for="usr_discount" class="form-label">Discount</label>
                            </div>
                        </div>
                        <!-- <div class="col-md-12 vsb payment">
                            <label>Payment Mode<span class="text-danger">*</span></label>
                            <select name="paymentMode" class="form-control " id="paymentMode">
                                <option value="">Select Payment Mode</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Online">Online</option>
                                <option value="Bank">Bank</option>
                            </select>
                            <div class="payment-mode-error text-danger"></div>
                            <br>
                            <div class="paymentModeRemarks" style="display:none;">
                                <input type="text" name="paymentModeRemarks" class="form-control "
                                    placeholder="Enter Details Here" id="paymentModeRemarks">
                                <div class="payment-mode-remarks-error text-danger"></div>
                            </div>
                            {{-- for bank details  --}}
                            <div class="bank-details" style="display:none;">
                                <input type="text" name="bankName" class="form-control "
                                    placeholder="Enter Bank Name" id="bankName">
                                <div class="bank-name-error text-danger"></div>
                                <br>
                                <input type="text" name="accountNo" class="form-control "
                                    placeholder="Enter Account No" id="accountNo">
                                <div class="account-no-error text-danger"></div>
                                <br>
                                <input type="text" name="ifscCode" class="form-control "
                                    placeholder="Enter IFSC Code" id="ifscCode">
                                <div class="ifsc-code-error text-danger"></div>
                                <br>
                            </div>
                            {{-- end bank details  --}}
                        </div> -->
                        <div class="col-md-12 vsb payment payment-section-payy">
                        <div class="payment-header-payy">Payment Method</div>
                        <div class="form-floating input-group-payy">
                            <select name="paymentMode" class="form-control form-select-payy payment-select-payy" placeholder="Payment Mode" id="paymentMode" required>
                            <option value="">Select Payment Mode *</option>
                            <option value="Cash">Cash</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Online">Online</option>
                            <option value="Bank">Bank</option>
                            </select>
                            <div class="payment-mode-error text-danger"></div>
                        </div>

                            <div class="paymentModeRemarks input-group-payy" style="display:none;">
                                <input type="text" name="paymentModeRemarks" class="form-control payment-input-payy" placeholder="Enter Payment Details" id="paymentModeRemarks">
                                <div class="payment-mode-remarks-error text-danger"></div>
                            </div>

                            <div class="bank-details input-group-payy" style="display:none;">
                                <div class="bank-details-grid-payy">
                                <div class="bank-input-group-payy">
                                    <input type="text" name="bankName" class="form-control payment-input-payy" placeholder="Enter Bank Name" id="bankName">
                                    <div class="bank-name-error text-danger"></div>
                                </div>
                                <div class="bank-input-group-payy">
                                    <input type="text" name="accountNo" class="form-control payment-input-payy" placeholder="Enter Account No" id="accountNo">
                                    <div class="account-no-error text-danger"></div>
                                </div>
                                <div class="bank-input-group-payy">
                                    <input type="text" name="ifscCode" class="form-control payment-input-payy" placeholder="Enter IFSC Code" id="ifscCode">
                                    <div class="ifsc-code-error text-danger"></div>
                                </div>
                                </div>
                            </div>
                            </div>

                        <div class="col-12">
                            <div class="form-floating input-group-payy">
                                <input id="usr-listening_score" name="remarks" type="text" class="form-control" placeholder="Remarks" required>
                                <input id="usr-listening_score remark_student" type="hidden" name="student_id">
                                <label for="usr-listening_score" class="form-label">Remark</label>
                                <span class="text-danger error-remark"></span>
                            </div>
                        </div>
                    </form>
                    <div class="row payment-button" style="display: none">
                        <div class="col-md-6 mb-4">
                            <button type="button " class="btn btn-info d-lg-block m-l-15 btnDiv " id="payment">
                                Payment
                                <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <div class="row submit-amount" style="display: none">
                        <div class="col-md-6 mb-4">
                            <button type="button " class="btn btn-info d-lg-block m-l-15 btnDiv " id="submitData">
                                 Submit
                                <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="workspace-payment-history">
            <h3>Payment History</h3>
            <div class="workspace-payment-history-table"><table class="table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Master Service</th>
                        <th>Amount</th>
                        <th>Remarks</th>
                        <th>View</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="score-table">

                </tbody>
            </table></div>
        </div>
    </div>
</div>
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Master Service</th>
                            <th>Program Name</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody id="payment_table">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="student_second_id" name="student_second_id" id="student_second_id">
{{-- test Score --}}
<div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="viewlead">
    <div class="sidebar-headerset" style="  box-shadow: 0 1.6rem 3rem rgba(0,0,0,.1);">
        <div class="sidebar-headersets">
            <h5> Lead Details </h5>
        </div>
        <div class="sidebar-headerclose">
            <a data-bs-dismiss="offcanvas" aria-label="Close">
                <img src="{{asset('assets/img/close.png')}}" alt="Close Icon">
            </a>
        </div>
    </div>
    <div class="table-responsive" style="  margin: 0px 12px;">
        <table class="table table-striped custom-table mb-0" id="lead-details-table">
        </table>
    </div>
</div>
{{-- test Score --}}
