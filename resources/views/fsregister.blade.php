@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrierung') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('fs-register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="iban" class="col-md-4 col-form-label text-md-right">{{ __('Iban') }}</label>

                            <div class="col-md-6">
                                <input id="iban" type="text" onkeyup="saveInputValue(this)" class="form-control @error('iban') is-invalid @enderror" name="iban" value="{{ old('iban') }}" required autocomplete="iban" autofocus>

                                @error('iban')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="allChildren" id="allChildren">
                        
                        </div>
                        
                        <hr>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" onclick="addNewChild()" class="btn btn-primary">
                                    {{ __('Kind hinzufügen') }}
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Weiter') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    var childCounter = 0;
    getAllInputValues();

    function addNewChild() {
        const container = document.getElementById('allChildren');
        container.innerHTML += `<div class="card mb-1" id=` + childCounter + `>
            <div class="card-header d-flex justify-content-between align-items-center">
                Kind ` + (childCounter+1) + `
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteChild(this)">Delete</button>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <label for="firstnameChild` + childCounter + `" class="col-md-4 col-form-label text-md-right">{{ __('Vorname') }}</label>

                    <div class="col-md-6">
                        <input id="firstnameChild` + childCounter + `" type="text" onkeyup="saveInputValue(this)" class="form-control @error('firstnameChild` + childCounter + `') is-invalid @enderror" name="firstnameChild` + childCounter + `" value="{{ old('firstnameChild` + childCounter + `') }}" required autocomplete="firstnameChild` + childCounter + `" autofocus>

                        @error('firstnameChild` + childCounter + `')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="birthdayChild` + childCounter + `" class="col-md-4 col-form-label text-md-right">{{ __('Geburtstag') }}</label>

                    <div class="col-md-6">
                        <input id="birthdayChild` + childCounter + `" type="text" onkeyup="saveInputValue(this)" class="form-control @error('birthdayChild` + childCounter + `') is-invalid @enderror" name="birthdayChild` + childCounter + `" value="{{ old('birthdayChild` + childCounter + `') }}" required autocomplete="birthdayChild` + childCounter + `" autofocus>

                        @error('birthdayChild` + childCounter + `')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="commentChild` + childCounter + `" class="col-md-4 col-form-label text-md-right">{{ __('Bemerkungen') }}</label>

                    <div class="col-md-6">
                        <input id="commentChild` + childCounter + `" type="text" onkeyup="saveInputValue(this)" class="form-control @error('commentChild` + childCounter + `') is-invalid @enderror" name="commentChild` + childCounter + `" value="{{ old('commentChild` + childCounter + `') }}" required autocomplete="commentChild` + childCounter + `" autofocus>

                        @error('commentChild` + childCounter + `')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>`;
        childCounter++;
        setInputIds();
        getAllInputValues();
    }

    // for localstorage identification since id changes
    function setInputIds() {
        const inputs = document.getElementsByTagName('input');

        for (let input of inputs) {
            if (input.type != "hidden" && !input.hasAttribute("localstorageid")) {
                document.getElementById(input.id).setAttribute("localstorageid", "input-" + Math.floor(Math.random() * 10000));
            }
        }
    }

    function getAllInputValues() {
        NodeList.prototype.forEach = Array.prototype.forEach;
        const inputs = document.getElementsByTagName('input');

        for (let input of inputs) {
            if (document.getElementById(input.id) != null)
                document.getElementById(input.id).value = getInputValue(input.getAttribute('localstorageid')) || "";
        };
    }

    function getInputValue(id) {
        return localStorage.getItem(id) || "";
    }

    function saveInputValue(input) {
        localStorage.setItem(input.getAttribute('localstorageid'), input.value);
    }

    function deleteChild(btn) {
        NodeList.prototype.forEach = Array.prototype.forEach;
        const id = parseInt(btn.parentNode.parentNode.id);
        const container = document.getElementById('allChildren');
        const allChildren = container.childNodes;
        var toRemove = [];

        allChildren.forEach(function(child) {
            if (parseInt(id) == parseInt(child.id)) {
                toRemove.push(parseInt(child.id));
            } else if (parseInt(id) < parseInt(child.id)) {
                const id = child.id;
                child.innerHTML = child.innerHTML.replaceAll("firstnameChild" + id, "firstnameChild" + (parseInt(id) - 1));
                child.innerHTML = child.innerHTML.replaceAll("birthdayChild" + id, "birthdayChild" + (parseInt(id) - 1));
                child.innerHTML = child.innerHTML.replaceAll("commentChild" + id, "commentChild" + (parseInt(id) - 1));
                const idIndex = child.innerHTML.indexOf("Kind") + 5;
                child.innerHTML = child.innerHTML.substr(0, idIndex) + (child.id) + child.innerHTML.substr(idIndex + 1);
                child.id = parseInt(child.id) - 1;
            }
        });

        for (let i = 0; i < toRemove.length; i++) {
            const indexToRemove = toRemove[i];
            document.getElementById('allChildren').removeChild(document.getElementById('allChildren').childNodes[indexToRemove]);
        }

        childCounter--;
        getAllInputValues();
    }
</script>

@endsection