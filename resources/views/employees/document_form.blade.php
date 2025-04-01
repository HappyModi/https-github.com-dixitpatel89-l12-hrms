@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Generate Employee Documents</h4>

    <div class="mb-3">
        <label for="documentType" class="form-label">Select Document Type</label>
        <select id="documentType" class="form-select">
            <option value="">-- Select --</option>
            <option value="offer_letter">Offer Letter</option>
            <option value="appointment_letter">Appointment Letter</option>
            <option value="experience_letter">Experience Letter</option>
        </select>
    </div>

    <div id="documentForm" class="mt-4" style="display: none;">
        <h5 class="mb-3" id="documentTitle"></h5>
        <form id="documentForm">
            <div class="row">
                <div class="col-md-12">
                    <label for="documentContent" class="form-label">Letter Content</label>
                    <textarea class="form-control" id="documentContent"></textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="button" id="generateDocumentPdf" class="btn btn-primary">Generate PDF</button>
            </div>
        </form>
    </div>
</div>

<!-- Include CKEditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        CKEDITOR.replace('documentContent', { height: 400 });

        let documentType = document.getElementById("documentType");
        let documentForm = document.getElementById("documentForm");
        let documentTitle = document.getElementById("documentTitle");

        documentType.addEventListener("change", function () {
            let selectedValue = this.value;

            if (selectedValue) {
                documentForm.style.display = "block";
                documentTitle.innerText = selectedValue.replace("_", " ") + " Details";

                // Fetch template from the server
                fetch(`/get-template/${selectedValue}`)
                    .then(response => response.json())
                    .then(data => {
                        CKEDITOR.instances.documentContent.setData(data.template);
                    });
            } else {
                documentForm.style.display = "none";
            }
        });

        document.getElementById("generateDocumentPdf").addEventListener("click", function () {
            let content = CKEDITOR.instances.documentContent.getData();
            let selectedType = documentType.value;

            if (!selectedType) {
                alert("Please select a document type.");
                return;
            }

            if (!content) {
                alert("Please enter the letter content.");
                return;
            }

            fetch("{{ route('employees.generateDocumentPdf') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    content: content,
                    type: selectedType
                })
            })
            .then(response => response.blob())
            .then(blob => {
                let url = window.URL.createObjectURL(blob);
                let a = document.createElement("a");
                a.href = url;
                a.download = "EmployeeDocument.pdf";
                document.body.appendChild(a);
                a.click();
                a.remove();
            })
            .catch(error => {
                alert("Error generating PDF.");
                console.error(error);
            });
        });
    });
</script>
@endsection
