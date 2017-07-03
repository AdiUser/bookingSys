 <div class="container">
            <div class="row" style="margin-bottom: 0px;">
                <div class="col s12">
                    <ul class="tabs green-">
                        <li class="tab col s2">
                            <a class="active" href="#form_rafting">
                                <span class="img_icon">
                                    <img src="/img/Rafting.png">
                                    <span class="hide-on-small-only ">Rafting
                            </span>
                            </a>
</span></li>
<li class="tab col s2">
    <a href="#form_camping">
        <span class="img_icon">
            <img src="/img/camping.png">
        </span>
        <span class="hide-on-small-only ">Camping
                            
                            
                            </span>
    </a>
</li>
<li class="tab col s2 disabled">
    <a href="#form_trekking">
        <span class="img_icon">
            <img src="/img/trek.png">
        </span>
        <span class="hide-on-small-only ">Trekking
                            
                            </span>
    </a>
</li>
<li class="tab col s2">
    <a href="#form_hotels">
        <span class="img_icon">
            <img src="/img/hotel.png">
        </span>
        <span class="hide-on-small-only">Hotels
                            
                            
                            </span>
    </a>
</li>
<li class="tab col s2">
    <a href="#form_sightseeing">
        <span class="img_icon">
            <img src="/img/sightseeing.png">
        </span>
        <span class="hide-on-small-only ">Sigthseeing
                            </span>
    </a>
</li>
<li class="tab col s2">
    <a href="#form_homestay">
        <span class="img_icon">
            <img src="/img/homestay.png">
        </span>
        <span class="hide-on-small-only ">Homestay
                            </span>
    </a>
</li>
</ul></div></div>
<div id="form_rafting" class="tab col s12 divcover">
    <div class="row">
        <form action="/clogs/booknow.php" method="POST" class="down_the_alter">
            <!-- container1 -->
            <div class="col s12 l3 m12">
                <div class="col s2 l4 m3" style=" padding-top: 23px;">
                    <img src="/img/pick-date.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8">
                    <input id="date__rafting" required type="text" name="rafting_date" value="" placeholder="Pick a date" class="date_in date__" readonly="readonly">
                    <label for="date_in">Arrival</label>
                </div>
            </div>
            <!-- container2 -->
            <div class="col s12 l3 m12">
                <div class="col s2 l4 m3" style="padding-top: 23px;">
                    <img src="/img/Select-stretch.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8">
                    <select name="rafting_strech" required>
                        <option value="" disabled value="" selected>Select Stretch</option>
                        <option value="9">9 KM</option>
                        <option value="16">16 KM</option>
                        <option value="26">26 KM</option>
                        <option value="36">36 KM</option>
                    </select>
                    <label>Stretch</label>
                </div>
            </div>
            <!-- container 3 -->
            <div class="col s12 l3 m12">
                <div class="col s2 l4 m3" style="padding-top: 23px;">
                    <img src="/img/people.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8">
                    <input required type="number" name="rafting_people" class="validate" min="1">
                    <label for="num_people">No. of People</label>
                </div>
            </div>
            <!-- container 4 -->
            <div class="col s12 m2 l3">
                <div class="box bg-3">
                    <button type="submit" name="rafting_btn" class="button button--nina button--border-thin button--round-s" data-text="Book Now">
                        <span>B</span>
                        <span>o</span>
                        <span>o</span>
                        <span>k</span>
                        <span>N</span>
                        <span>o</span>
                        <span>w</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="form_camping" class="col s12 divcover">
    <div class="row">
        <form action="/clogs/booknow.php" method="POST" class="down_the_alter">
            <!-- container1 -->
            <div class="col s12 m12 l2">
                <div class="col s2 l4 m3" style=" padding-top: 23px;">
                    <img src="/img/pick-date.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8 pad">
                    <input readonly="readonly" id="date_arr_camp" required type="text" name="camping_in" value="" placeholder="Pick a date" class="date_in date__">
                    <label for="date_in">Arrival</label>
                </div>
            </div>
            <!-- container2 -->
            <div class="col s12 m12 l2">
                <div class="col s2 l4 m3" style=" padding-top: 23px;">
                    <img src="/img/pick-date.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8 pad">
                    <input readonly="readonly" id="date_dpr_camp" name="camping_out" required type="text" value="" placeholder="Pick a date" class="date_in date__">
                    <label for="date_in">Departure</label>
                </div>
            </div>
            <!-- container3 -->
            <div class="col s12 m12 l3">
                <div class="col s2 l2 m3 pad" style=" padding-top: 23px;">
                    <img src="/img/trip-type.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l10">
                    <select name="camping_type" required>
                        <option selected disabled value="">Select Camp Type</option>
                        <option value="dlx">Deluxe</option>
                        <option value="sdlx">Super Deluxe</option>
                        <option value="lxry">Luxury</option>
                        <option value="slxry">Super Luxury</option>
                    </select>
                    <label for="hote_type">Camp Type</label>
                </div>
            </div>
            <!-- container4 -->
            <div class="col s12 l2 m12">
                <div class="col s4 l4 m1" style=" padding-top: 23px;">
                    <img src="/img/people.png" class="hwhy"></img>
                </div>
                <div class="input-field col s8 m2 l8">
                    <input required type="number" name="camping_people" class="validate" min="1">
                    <label for="num_people">No. of People</label>
                </div>
            </div>
            <!-- container5 -->
            <div class="col s12 m12 l3">
                <div class="box bg-3">
                    <input required type="text" name="camping_days" id="hidden_days_input_camp" style="display: none;">
                    <button required type="submit" name="camping_btn" class="button button--nina button--border-thin button--round-s" data-text="Book Now">
                        <span>B</span>
                        <span>o</span>
                        <span>o</span>
                        <span>k</span>
                        <span>N</span>
                        <span>o</span>
                        <span>w</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="form_trekking" class="col s12 divcover">
    <div class="row">
        <form action="/clogs/booknow.php" method="POST" class="down_the_alter">
            <div class="col s1 l1 m1" style="padding: 2%">
                <img src="/img/trip-type.png" class="hwhy"></img>
            </div>
            <div class="input-field col s12 m3 l3">
                <select name="trekking_type" required>
                    <option selected disabled value="">Select Departure Type</option>
                    <option value="fdpr">Fixed Departure</option>
                    <option value="cdpr">Customized Departure</option>
                </select>
                <label for="hote_type">Departure Type</label>
            </div>
            <div class="col s1 l1 m1" style="padding: 2%">
                <img src="/img/people.png" class="hwhy"></img>
            </div>
            <div class="input-field col s12 m2 l1">
                <input required type="number" value="" name="trekking_people" class="validate" min="1">
                <label for="num_people">No. of People</label>
            </div>
            <div class="col s12 m2 l2">
                <div class="box bg-3">
                    <button required type="submit" name="trekking_btn" class="button button--nina button--border-thin button--round-s" data-text="Book Now">
                        <span>B</span>
                        <span>o</span>
                        <span>o</span>
                        <span>k</span>
                        <span>N</span>
                        <span>o</span>
                        <span>w</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="form_hotels" class="col s12 divcover">
    <div class="row">
        <form action="/clogs/booknow.php" method="POST" class="down_the_alter">
            <!-- container1 -->
            <div class="col s12 m12 l2">
                <div class="col s2 l4 m3" style=" padding-top: 23px;">
                    <img src="/img/pick-date.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8 pad">
                    <input readonly="readonly" id="date_arr_hotels" required type="text" value="" name="hotel_in" placeholder="Pick a date" class="date_in date__">
                    <label for="date_in">Check In</label>
                </div>
            </div>
            <!-- container2 -->
            <div class="col s12 m12 l2">
                <div class="col s2 l4 m3" style=" padding-top: 23px;">
                    <img src="/img/pick-date.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8 pad">
                    <input readonly="readonly" id="date_dpr_hotels" required type="text" name="hotel_out" value="" placeholder="Pick a date" class="date_in date__">
                    <label for="date_in">Check Out</label>
                </div>
            </div>
            <!-- container3 -->
            <div class="col s12 m12 l3">
                <div class="col s2 l2 m3 pad" style=" padding-top: 23px;">
                    <img src="/img/trip-type.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l10">
                    <select name="hotel_type" required>
                        <option selected disabled value="">Select Hotel Type</option>
                        <option value="bgd">Budget</option>
                        <option value="ac">AC</option>
                        <option value="lxry">Luxury</option>
                        <option value="slxry">Super Luxury</option>
                    </select>
                    <label for="hote_type">Hotel Type</label>
                </div>
            </div>
            <!-- container4 -->
            <div class="col s12 l2 m12">
                <div class="col s3 l4 m1" style=" padding-top: 23px;">
                    <img src="/img/rooms.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m2 l8">
                    <input required type="number" value="" name="hotel_rooms" class="validate" min="1">
                    <label for="num_people">No. of Rooms</label>
                </div>
            </div>
            <!-- container5 -->
            <div class="col s12 m12 l3">
                <div class="box bg-3">
                    <input required type="number" name="days" id="hidden_input_days_hotels" style="display: none;">
                    <button required type="submit" name="hotel_btn" class="button button--nina button--border-thin button--round-s" data-text="Book Now">
                        <span>B</span>
                        <span>o</span>
                        <span>o</span>
                        <span>k</span>
                        <span>N</span>
                        <span>o</span>
                        <span>w</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="form_sightseeing" class="col s12 divcover">
    <div class="row">
        <form action="/clogs/booknow.php" method="POST" class="down_the_alter">
            <!-- container1 -->
            <div class="col s12 l3 m12">
                <div class="col s2 l4 m3" style=" padding-top: 23px;">
                    <img src="/img/pick-date.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8">
                    <input readonly="readonly" id="date_arr_site" name="site_in" required type="text" value="" placeholder="Pick a date" class="date_in date__">
                    <label for="date_in">Arrival</label>
                </div>
            </div>
            <!-- container2 -->
            <div class="col s12 l4 m12">
                <div class="col s2 l2 m3" style=" padding-top: 23px;">
                    <img src="/img/sites.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l10">
                    <select multiple name="sites[]" required>
                        <option value="" disabled>Select Sites</option>
                        <option value=01>Rishikesh</option>
                        <option value="02">Haridwar</option>
                        <option value="03">Spriritual Tour</option>
                    </select>
                    <label>Sites</label>
                </div>
            </div>
            <!-- container3 -->
            <div class="col s12 l2 m12">
                <div class="col s2 l4 m3" style=" padding-top: 23px;">
                    <img src="/img/people.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8">
                    <input required type="number" name="site_people" class="validate" min="1">
                    <label for="num_people">No. of Groups</label>
                </div>
            </div>
            <!-- container4 -->
            <div class="col s12 l3 m12">
                <div class="box bg-3">
                    <button required type="submit" name="site_btn" class="button button--nina button--border-thin button--round-s" data-text="Book Now">
                        <span>B</span>
                        <span>o</span>
                        <span>o</span>
                        <span>k</span>
                        <span>N</span>
                        <span>o</span>
                        <span>w</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="form_homestay" class="col s12 divcover">
    <div class="row">
        <form action="/clogs/booknow.php" method="POST" class="down_the_alter">
            <!-- container1 -->
            <div class="col s12 l3 m12">
                <div class="col s2 l4 m3" style=" padding-top: 23px;">
                    <img src="/img/pick-date.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8">
                    <input readonly="readonly" id="date_arr_homestay" name="homestay_in" required type="text" value="" placeholder="Pick a date" class="date_in date__">
                    <label for="date_in">Check In</label>
                </div>
            </div>
            <!-- container2 -->
            <div class="col s12 l3 m12">
                <div class="col s2 l4 m3" style="padding-top: 23px;">
                    <img src="/img/pick-date.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8">
                    <input readonly="readonly" id="date_dpr_homestay" required type="text" name="homestay_out" value="" placeholder="Pick a date" class="date_in date__">
                    <label for="date_in">Check Out</label>
                </div>
            </div>
            <!-- container 3 -->
            <div class="col s12 l3 m12">
                <div class="col s2 l4 m3" style="padding-top: 23px;">
                    <img src="/img/rooms.png" class="hwhy"></img>
                </div>
                <div class="input-field col s9 m8 l8">
                    <input required type="number" name="homestay_rooms" class="validate" min="1">
                    <label for="num_people">No. of Rooms</label>
                </div>
            </div>
            <!-- container 4 -->
            <div class="col s12 m2 l3">
                <input required type="text" name="homestay_days" id="hidden_days_input_homestay" style="display: none;">
                <div class="box bg-3">
                    <button required type="submit" name="homestay_btn" class="button button--nina button--border-thin button--round-s" data-text="Book Now">
                        <span>B</span>
                        <span>o</span>
                        <span>o</span>
                        <span>k</span>
                        <span>N</span>
                        <span>o</span>
                        <span>w</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>