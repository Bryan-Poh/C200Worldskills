@section('content')
    <div class="panel-heading">

            <h2 class="mt-3 mb-3">WorldSkills Conference 2019</h2>
            <hr/>
        <form method = "post" action="#">
        <div class="form-group">

            <div class="form-check-inline">
                <label class="form-check-label" for="check1">
                    <input style="border: black 1px" type="checkbox" id="check1" name="ticket[]" value="normal" class="chkboxlist form-check-input">Normal Ticket
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label" for="check2">
                    <input style="border: black 1px" type="checkbox" id="check2" name="ticket[]" value="earlyBird" class="chkboxlist form-check-input">Early Bird
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label" for="check3">
                    <input style="border: black 1px" type="checkbox" id="check3" name="ticket[]" value="hotelPack" class="chkboxlist form-check-input">Hotel Package
                </label>
            </div>
        </div>
            <div class="form-group">
                <label>Select Additional Workshops you want to book:</label>
                <div class="form-check">
                    <label class="form-check-label" for="check1">
                        <input type="checkbox" id="check1" name="additional[]" value="y" class="chkboxlist form-check-input">Designing Skills path
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="check2">
                        <input type="checkbox" id="check2" name="additional[]" value="g" class="chkboxlist form-check-input">Education ecosystem
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="check3">
                        <input type="checkbox" id="check3" name="additional[]" value="g" class="chkboxlist form-check-input">Training and innovate
                    </label>
                </div>
                <div class="form-group">
                    <div class="float-right">
                        Event Ticket:
                    </div>
                    <div class="float-right">
                        Additional Workshops:
                    </div>
                    <div class="float-right">
                        -------------------------------
                    </div>
                    <div class="float-right">
                        Total:
                    </div>
                </div>
                <input class=" float-right btn btn-block btn-primary" type="submit" value="Purchase"/>
            </div>
        </form>
    </div>
