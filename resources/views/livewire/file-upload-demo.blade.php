<div class="space-y-8">
    <div>
        <h3 class="text-lg font-semibold mb-4">Basic File Upload</h3>
        <x-strata::file-input
            wire:model.live="singleFile"
            label="Click or drag file to upload"
            hint="Supported formats: All files, max 10MB"
        />
        @if($singleFile)
            <div class="mt-4">
                <x-strata::file-input.list>
                    <x-strata::file-input.item
                        :fileName="$singleFile->getClientOriginalName()"
                        :fileSize="number_format($singleFile->getSize() / 1024, 2) . ' KB'"
                        :fileType="$singleFile->getMimeType()"
                        onRemove="clearAvatar"
                    />
                </x-strata::file-input.list>
            </div>
        @endif
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Multiple File Upload with Clear All</h3>
        <x-strata::file-input
            wire:model.live="multipleFiles"
            multiple
            label="Click or drag files to upload"
            hint="Select multiple files"
        />
        @if(count($multipleFiles) > 0)
            <div class="mt-4">
                <x-strata::file-input.list
                    clearable
                    title="Selected Files"
                    onClear="clearAllMultipleFiles"
                >
                    @foreach($multipleFiles as $index => $file)
                        <x-strata::file-input.item
                            :fileName="$file->getClientOriginalName()"
                            :fileSize="number_format($file->getSize() / 1024, 2) . ' KB'"
                            :fileType="$file->getMimeType()"
                            :onRemove="'removeMultipleFile(' . $index . ')'"
                        />
                    @endforeach
                </x-strata::file-input.list>
            </div>
        @endif
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Current State:</p>
            <p class="text-sm text-muted-foreground">Files selected: {{ count($multipleFiles) }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Upload Progress Indicator</h3>
        <p class="text-sm text-muted-foreground mb-3">Upload large files to see the progress bar in action</p>
        <x-strata::file-input
            wire:model="progressFiles"
            multiple
            label="Upload files with progress tracking"
            hint="Progress bar appears during upload"
        />
        @if(count($progressFiles) > 0)
            <div class="mt-4">
                <x-strata::file-input.list clearable onClear="clearAllProgressFiles">
                    @foreach($progressFiles as $index => $file)
                        <x-strata::file-input.item
                            :fileName="$file->getClientOriginalName()"
                            :fileSize="number_format($file->getSize() / 1024, 2) . ' KB'"
                            :onRemove="'removeProgressFile(' . $index . ')'"
                        />
                    @endforeach
                </x-strata::file-input.list>
            </div>
        @endif
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Max Files Limit (Client-Side Validation)</h3>
        <p class="text-sm text-muted-foreground mb-3">Try uploading more than 3 files - validation error appears instantly</p>
        <x-strata::file-input
            wire:model.live="limitedFiles"
            multiple
            :maxFiles="3"
            label="Upload up to 3 files"
            hint="Maximum 3 files allowed"
        />
        @if(count($limitedFiles) > 0)
            <div class="mt-4">
                <x-strata::file-input.list clearable onClear="clearAllLimitedFiles">
                    @foreach($limitedFiles as $index => $file)
                        <x-strata::file-input.item
                            :fileName="$file->getClientOriginalName()"
                            :fileSize="number_format($file->getSize() / 1024, 2) . ' KB'"
                            :onRemove="'removeLimitedFile(' . $index . ')'"
                        />
                    @endforeach
                </x-strata::file-input.list>
            </div>
        @endif
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Max Size Validation (Client-Side)</h3>
        <p class="text-sm text-muted-foreground mb-3">Try uploading a file larger than 1MB - instant validation</p>
        <x-strata::file-input
            wire:model.live="validatedFiles"
            multiple
            accept=".pdf"
            :maxSize="1024 * 1024"
            label="Upload PDFs (max 1MB each)"
            hint="Only PDF files under 1MB"
            :error="$validationError"
        />
        @if(count($validatedFiles) > 0)
            <div class="mt-4">
                <x-strata::file-input.list clearable onClear="clearAllValidatedFiles">
                    @foreach($validatedFiles as $index => $file)
                        <x-strata::file-input.item
                            :fileName="$file->getClientOriginalName()"
                            :fileSize="number_format($file->getSize() / 1024, 2) . ' KB'"
                            :onRemove="'removeValidatedFile(' . $index . ')'"
                        />
                    @endforeach
                </x-strata::file-input.list>
            </div>
        @endif
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Custom Icon</h3>
        <x-strata::file-input
            icon="paperclip"
            label="Upload with custom icon"
            hint="Uses paperclip icon instead of default upload-cloud"
        />
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Size Variants</h3>
        <div class="space-y-4">
            <div>
                <p class="text-sm text-muted-foreground mb-2">Small</p>
                <x-strata::file-input
                    size="sm"
                    label="Small upload"
                    hint="Compact size"
                />
            </div>
            <div>
                <p class="text-sm text-muted-foreground mb-2">Medium (Default)</p>
                <x-strata::file-input
                    size="md"
                    label="Medium upload"
                    hint="Default size"
                />
            </div>
            <div>
                <p class="text-sm text-muted-foreground mb-2">Large</p>
                <x-strata::file-input
                    size="lg"
                    label="Large upload"
                    hint="Spacious size"
                />
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Validation States</h3>
        <div class="space-y-4">
            <x-strata::file-input
                state="default"
                label="Default state"
                hint="Ready to upload"
            />
            <x-strata::file-input
                state="success"
                label="Success state"
                hint="Files uploaded successfully"
            />
            <x-strata::file-input
                state="error"
                label="Error state"
                hint="Upload failed, please try again"
            />
            <x-strata::file-input
                state="warning"
                label="Warning state"
                hint="File size exceeds recommended limit"
            />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Disabled State</h3>
        <x-strata::file-input
            disabled
            label="Disabled upload"
            hint="File upload is currently disabled"
        />
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Image Upload with Previews & Extension Badges</h3>
        <x-strata::file-input
            wire:model.live="images"
            multiple
            accept="image/*"
            label="Upload images"
            hint="PNG, JPG, GIF up to 2MB each"
        />
        @error('images.*')
            <p class="text-sm text-destructive mt-2">{{ $message }}</p>
        @enderror
        @if(count($images) > 0)
            <div class="mt-4">
                <x-strata::file-input.list clearable title="Uploaded Images" onClear="clearAllImages">
                    @foreach($images as $index => $image)
                        <x-strata::file-input.item
                            :fileName="$image->getClientOriginalName()"
                            :fileSize="number_format($image->getSize() / 1024, 2) . ' KB'"
                            :fileType="$image->getMimeType()"
                            :preview="$image->temporaryUrl()"
                            :onRemove="'removeImage(' . $index . ')'"
                        />
                    @endforeach
                </x-strata::file-input.list>
            </div>
        @endif
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Document Upload with File Type Badges</h3>
        <x-strata::file-input
            wire:model.live="documents"
            multiple
            accept=".pdf,.doc,.docx"
            label="Upload documents"
            hint="PDF, DOC, DOCX up to 5MB each"
        />
        @error('documents.*')
            <p class="text-sm text-destructive mt-2">{{ $message }}</p>
        @enderror
        @if(count($documents) > 0)
            <div class="mt-4">
                <x-strata::file-input.list clearable title="Uploaded Documents" onClear="clearAllDocuments">
                    @foreach($documents as $index => $document)
                        <x-strata::file-input.item
                            :fileName="$document->getClientOriginalName()"
                            :fileSize="number_format($document->getSize() / 1024, 2) . ' KB'"
                            :fileType="$document->getMimeType()"
                            :onRemove="'removeDocument(' . $index . ')'"
                        />
                    @endforeach
                </x-strata::file-input.list>
            </div>
        @endif
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Avatar Upload (Single Image)</h3>
        <x-strata::file-input
            wire:model.live="avatar"
            accept="image/*"
            label="Upload your avatar"
            hint="Single image, max 2MB"
            size="sm"
        />
        @error('avatar')
            <p class="text-sm text-destructive mt-2">{{ $message }}</p>
        @enderror
        @if($avatar)
            <div class="mt-4">
                <x-strata::file-input.item
                    :fileName="$avatar->getClientOriginalName()"
                    :fileSize="number_format($avatar->getSize() / 1024, 2) . ' KB'"
                    :preview="$avatar->temporaryUrl()"
                    onRemove="clearAvatar"
                />
            </div>
        @endif
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Form Submission</h3>
        <form wire:submit="submit" class="space-y-4">
            <x-strata::file-input
                wire:model="documents"
                multiple
                accept=".pdf,.doc,.docx"
                label="Upload documents"
                hint="Required for submission"
            />

            <x-strata::file-input
                wire:model="images"
                multiple
                accept="image/*"
                label="Upload images"
                hint="Optional"
            />

            <x-strata::button type="submit">
                Submit Form
            </x-strata::button>

            @if($message)
                <div class="p-4 bg-success/10 text-success rounded-lg">
                    <p class="text-sm font-medium">{{ $message }}</p>
                </div>
            @endif
        </form>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Edit Form with Existing Images (Grid Gallery)</h3>
        <p class="text-sm text-muted-foreground mb-4">
            Demonstrates automatic grid layout for images. Remove existing images or upload new ones.
        </p>

        <x-strata::file-input
            wire:model.live="images"
            multiple
            accept="image/*"
            label="Add more images"
            hint="Upload additional images"
            :existingFiles="$existingImages"
            onRemoveExisting="removeExistingImage"
        />
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Edit Form with Existing Documents (List View)</h3>
        <p class="text-sm text-muted-foreground mb-4">
            Demonstrates automatic list layout for documents. Remove existing documents or upload new ones.
        </p>
        <x-strata::file-input
            wire:model.live="documents"
            multiple
            accept=".pdf,.doc,.docx,.pptx"
            label="Add more documents"
            hint="Upload additional documents"
            :existingFiles="$existingDocuments"
            onRemoveExisting="removeExistingDocument"
        />
    </div>
</div>
