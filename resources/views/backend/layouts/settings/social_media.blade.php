@extends('backend.app')

@section('title', 'Social Media settings')

@push('style')
    <style>
        .drop-custom {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
            padding: 15px;
            border: 1px solid #4CAF50;
            color: #313131;
            transition: all 0.3s ease;
        }

        .drop-custom:hover {
            background-color: #414241;
            color: white;
        }

        .btn {
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.1);
        }
    </style>
@endpush

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <div class="flex-wrap container-fluid d-flex flex-stack flex-sm-nowrap">
            <!--begin::Info-->
            <div class="flex-wrap d-flex flex-column align-items-start justify-content-center me-2">
                <!--begin::Title-->
                <h1 class="my-1 text-dark fw-bold fs-2">
                    Dashboard <small class="text-muted fs-6 fw-normal ms-1"></small>
                </h1>
                <!--end::Title-->

                <!--begin::Breadcrumb-->
                <ul class="my-1 breadcrumb fw-semibold fs-base">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
                            Home </a>
                    </li>

                    <li class="breadcrumb-item text-muted"> Setting </li>
                    <li class="breadcrumb-item text-muted"> Social Media </li>

                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Toolbar-->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-4 card-style">
                    <form action="{{ route('social.update') }}" method="POST">
                        @csrf
                        <div style="display: flex;justify-content: end;margin-bottom: 10px;">
                            <button class="btn btn-success" type="button" onclick="addSocialField()"
                                style="font-weight: 900" title="Add a new social media field">Add</button>
                        </div>
                        <div id="social_media_container">
                            @foreach ($social_link as $index => $link)
                                <div class="mb-3 social_media input-group dropdown">
                                    <input type="hidden" name="social_media_id[]" value="{{ $link->id }}">
                                    <select class="border dropdown-toggle" name="social_media[]"
                                        value="@isset($social_link){{ $link->social_media }}@endisset"
                                        title="Select a social media platform">
                                        <option class="dropdown-item">Select Social</option>
                                        <option class="dropdown-item" value="facebook"
                                            {{ $link->social_media == 'facebook' ? 'selected' : '' }}>Facebook
                                        </option>
                                        <option class="dropdown-item" value="twitter"
                                            {{ $link->social_media == 'twitter' ? 'selected' : '' }}>Twitter
                                        </option>
                                        <option class="dropdown-item" value="skype"
                                            {{ $link->social_media == 'skype' ? 'selected' : '' }}>Skype
                                        </option>
                                        <option class="dropdown-item" value="instagram"
                                            {{ $link->social_media == 'instagram' ? 'selected' : '' }}>Instagram
                                        </option>
                                        {{-- <option class="dropdown-item" value="youtube"
                                            {{ $link->social_media == 'youtube' ? 'selected' : '' }}>YouTube
                                        </option>
                                        <option class="dropdown-item" value="threads"
                                            {{ $link->social_media == 'threads' ? 'selected' : '' }}>Threads
                                        </option> --}}
                                    </select>
                                    <input type="url" class="form-control" aria-label="Text input with dropdown button"
                                        name="profile_link[]"
                                        value="@isset($social_link){{ $link->profile_link }}@endisset"
                                        placeholder="Enter the profile link here">
                                    <button class="btn btn-secondary removeSocialBtn" type="button"
                                        onclick="removeSocialField(this)" style="font-weight: 900"
                                        data-id="{{ $link->id }}" title="Remove this social media field">Remove</button>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 col-12">
                            <button type="submit" class="btn btn-primary" title="Submit the form">Submit</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger me-2"
                                title="Cancel and go back to the dashboard">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let socialFieldsCount = $('#social_media_container .social_media').length;

        function addSocialField() {
            const socialFieldsContainer = document.getElementById("social_media_container");

            if (socialFieldsCount < 4) {
                const newSocialField = document.createElement("div");
                newSocialField.className = "social_media input-group mb-3";
                newSocialField.innerHTML =
                    `
            <select class="dropdown-toggle drop-custom" name="social_media[]">
                <option class="dropdown-item">Select Social</option>
                <option class="dropdown-item" value="facebook">Facebook</option>
                <option class="dropdown-item" value="twitter">Twitter</option>
                <option class="dropdown-item" value="skype">skype</option>
                <option class="dropdown-item" value="instagram">Instagram</option>
            </select>
            <input type="url" class="form-control" aria-label="Text input with dropdown button" name="profile_link[]">
            <button class="btn btn-outline-secondary" type="button" onclick="removeSocialField(this)" style="font-weight: 900">Remove</button>`;

                socialFieldsContainer.appendChild(newSocialField);
                socialFieldsCount++;
                document.querySelectorAll('select[name="social_media[]"]').forEach(selectElement => {
                    selectElement.removeEventListener('change',
                        checkForDuplicateSocialMedia);
                    selectElement.addEventListener('change', checkForDuplicateSocialMedia);
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "You can only add Four social links fields!",
                });
            }
        }


        function removeSocialField(button) {
            const socialField = button.parentElement;
            socialField.remove();
            socialFieldsCount--;
            checkForDuplicateSocialMedia();
        }

        function checkForDuplicateSocialMedia() {
            const allSelections = document.querySelectorAll('select[name="social_media[]"]');
            const allValues = Array.from(allSelections).map(select => select.value);
            const hasDuplicate = allValues.some((value, index) => allValues.indexOf(value) !== index && value !==
                "Select Social");

            if (hasDuplicate) {
                swal.fire("You cannot add the same social media platform more than once.");
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "You cannot add the same social media platform more than once.",
                });
                allSelections.forEach(selectElement => {
                    if (allValues.filter(value => value === selectElement.value).length > 1) {
                        selectElement.value = "";
                    }
                });
            }
        }

        window.removeSocialField = function(button) {
            const socialLinkId = $(button).data('id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                url: '{{ route('social.delete', '') }}/' + socialLinkId,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $(button).closest('.social_media').remove();
                    socialFieldsCount--;
                    if (response.success === true) {

                        toastr.error(response.message);
                    } else if (response.errors) {
                        toastr.error(response.errors[0]);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong. Please try again.",
                    });
                }
            });
        };
    </script>
@endpush
