<div class="floating-form d-none" id="contact_form">
    <div class="contact-opener"><i class="fas fa-bug"></i></div>
    <div class="floating-form-heading">Let us know about the bug</div>
    <div id="contact_results"></div>
    <div id="form-row">
        <form wire:submit.prevent="sendBugInfo">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" id="name" wire:model.defer="name" required="true" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required="true" wire:model.defer="email" class="form-control">
            </div>

            <input type="hidden" name="page" value="{{request()->url()}}" class="form-control">

            <div class="form-group">
                <label>Regarding</label>
                <div class="">
                    <select wire:model.defer="subject" name="subject" class="form-control">
                        <option value="bug">Bug</option>
                        <option value="feature">Feature</option>
                        <option value="question">Question</option>
                    </select>
                </div>
            </div>

            <div class="form-group"><label>Message</label>
                <textarea rows="7" wire:model.defer="message" name="message" id="message" class="form-control" required="true"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" id="submit_btn" class="btn btn-sm btn-danger" value="Submit">
            </div>
        </form>
    </div>

    <style>
        /* floating box style */
        .floating-form { /*contact form wrapper*/
            max-width: 300px;
            padding: 19px 27px 23px 22px;
            border: 1px solid #ddd;
            right: -250px;
            position: fixed; /*Form position fixed*/
            top: 10px;
            background-color: #343a40;
            color: white;
            z-index: 9999;
        }

        .contact-opener { /*opener button*/
            position: absolute;
            left: -60px;
            transform: rotate(-90deg); /* rotate button -90deg */
            top: 60px;
            padding: 9px;
            color: #fff;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.43);
            cursor: pointer;
            border-radius: 5px 5px 0px 0px;
            background-color: black;
        }
    </style>
</div>
