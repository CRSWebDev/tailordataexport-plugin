<div class="container">
    <h1>Tailor and storage export/import</h1>
    <div class="row" style="margin-top: 30px;">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Data export
                    </h2>
                </div>
                <div class="card-body">
                    <p>
                        Export all Tailor data to a JSON file.
                    </p>
                    <button
                        type="button"
                        data-request="onGetTables"
                        data-request-success="downloadExport(event, data)"
                        class="btn btn-primary">
                        Download JSON
                    </button>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Data import
                    </h2>
                </div>
                <div class="card-body">
                    <p>Import previously exported JSON</p>
                    <?= Form::ajax('onImportData', ['data-request-message' => 'Importing...', 'flash' => true, 'files' => true, 'class' => 'form-elements']); ?>
                        <div class="form-group">
                            <input type="file" name="importFile" class="form-control" required accept="application/json">
                        </div>
                        <div class="callout fade in callout-info no-subheader">
                            <div class="header">
                                <i class="icon-info"></i>
                                <h3>This will delete all Tailor data. Use with care.</h3>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Import Tailor data</button>
                    <?= Form::close(); ?>
                </div>
            </div>
        </div>
    </div>
    <hr style="margin-top: 30px;">
    <div class="row" style="margin-top: 30px;">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Export Media Storage</h2>
                </div>
                <div class="card-body">
                    <p>Export all media storage to a ZIP file.</p>
                    <button
                        type="button"
                        data-request="onExportStorage"
                        data-request-success="downloadZip(event, data)"
                        class="btn btn-primary">
                        Download ZIP
                    </button>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Import Media Storage
                    </h2>
                </div>
                <div class="card-body">
                    <p>Import previously exported ZIP</p>
                    <?= Form::ajax('onImportStorage', ['data-request-message' => 'Importing...', 'flash' => true, 'files' => true, 'class' => 'form-elements']); ?>
                    <div class="form-group">
                        <input type="file" name="importFile" class="form-control" required accept="application/zip">
                    </div>
                    <div class="callout fade in callout-info no-subheader">
                        <div class="header">
                            <i class="icon-info"></i>
                            <h3>This will NOT delete any files but it WILL overwrite any existing files with the same name.</h3>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Import media storage</button>
                    <?= Form::close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function downloadExport(event, data) {
        var blob = new Blob([JSON.stringify(data)], {type: 'application/json'});
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'export.json';
        document.body.appendChild(a);
        a.click();
        a.remove();
    }

    function downloadZip(event, data) {
        var url = '/storage/' + data.result;
        var a = document.createElement('a');
        a.href = url;
        a.download = 'media.zip';
        document.body.appendChild(a);
        a.click();
        a.remove();
    }
</script>
