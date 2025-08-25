@php
    $hasWireModel = $attributes->wire('model');
    $inputId = $attributes->get('id') ?: 'file-upload-' . uniqid();
    $isMultiple = $multiple;
    $isGalleryView = $variant === 'gallery';
@endphp

<div
    x-data="strataFileUpload({
        hasWireModel: @js($hasWireModel),
        maxSize: @js($maxSize),
        accept: @js($accept),
        multiple: @js($multiple),
        mediaLibrary: @js($mediaLibrary),
        enableReordering: @js($enableReordering),
        maxSizeFormatted: @js($getMaxSizeFormatted())
    })"
    class="w-full"
>
    <!-- Hidden file input -->
    <input
        type="file"
        x-ref="fileInput"
        :multiple="multiple"
        :accept="accept"
        @if($name) name="{{ $name }}" @endif
        @if($hasWireModel) {{ $attributes->wire('model') }} @endif
        {{ $attributes->except(['wire:model', 'class', 'id']) }}
        class="sr-only"
        id="{{ $inputId }}"
    />

    @if($variant === 'gallery')
        <!-- Gallery View -->
        <div class="space-y-4">
            <!-- Upload Zone -->
            <div
                @dragover.prevent="handleDragOver"
                @dragleave.prevent="handleDragLeave"
                @drop.prevent="handleDrop"
                @click="openFileBrowser"
                :class="{ 'border-primary bg-primary/5': dragOver }"
                class="{{ $getVariantClasses() }} cursor-pointer hover:border-primary hover:bg-primary/5 transition-colors duration-200 text-center"
            >
                <div class="flex flex-col items-center gap-2">
                    <x-icon name="heroicon-o-cloud-arrow-up" class="w-8 h-8 text-muted-foreground" />
                    <p class="text-sm font-medium text-foreground">{{ $placeholder }}</p>
                    @if($helpText)
                        <p class="text-xs text-muted-foreground">{{ $helpText }}</p>
                    @endif
                    <p class="text-xs text-muted-foreground">Max size: {{ $getMaxSizeFormatted() }}</p>
                </div>
            </div>
            
            <!-- File Grid -->
            <div x-show="(multiple && files && files.length > 0) || (!multiple && files)" x-transition class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template x-for="file in multiple ? (files || []) : (files ? [files] : [])" :key="file ? getFileId(file) : 'empty'">
                    <div x-show="file" class="relative group">
                        <!-- File Preview Card -->
                        <div class="bg-card border border-border rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                            <!-- Image Preview or Icon -->
                            <div class="aspect-square mb-3 bg-muted rounded-md flex items-center justify-center overflow-hidden">
                                <template x-if="file && previews[getFileId(file)]">
                                    <img :src="previews[getFileId(file)]" :alt="getFileName(file)" class="w-full h-full object-cover" />
                                </template>
                                <template x-if="file && !previews[getFileId(file)]">
                                    <div x-html="getFileIconHtml(file, 'w-8 h-8 text-muted-foreground')"></div>
                                </template>
                            </div>
                            
                            <!-- File Info -->
                            <div class="space-y-1">
                                <p class="text-sm font-medium text-foreground truncate" x-text="getFileName(file)" :title="getFileName(file)"></p>
                                <p class="text-xs text-muted-foreground" x-text="formatFileSize(getFileSize(file))"></p>
                            </div>
                            
                            <!-- Upload Progress -->
                            <div x-show="progress[getFileId(file)] !== undefined && progress[getFileId(file)] < 100" class="mt-2">
                                <div class="w-full bg-muted rounded-full h-1">
                                    <div class="bg-primary h-1 rounded-full transition-all duration-300" :style="`width: ${progress[getFileId(file)] || 0}%`"></div>
                                </div>
                            </div>
                            
                            <!-- Error Message -->
                            <div x-show="errors[getFileId(file)]" class="mt-2">
                                <p class="text-xs text-destructive" x-text="errors[getFileId(file)]"></p>
                            </div>
                        </div>
                        
                        <!-- Remove Button -->
                        <button
                            type="button"
                            @click.stop="removeFile(getFileId(file))"
                            class="absolute -top-2 -right-2 w-6 h-6 bg-destructive text-destructive-foreground rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-destructive/90"
                        >
                            <span class="text-sm">×</span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    @else
        <!-- Default/Compact View -->
        <div class="space-y-4">
            <!-- Upload Zone -->
            <div
                @dragover.prevent="handleDragOver"
                @dragleave.prevent="handleDragLeave"
                @drop.prevent="handleDrop"
                @click="openFileBrowser"
                :class="{ 'border-primary bg-primary/5': dragOver }"
                class="{{ $getVariantClasses() }} cursor-pointer hover:border-primary hover:bg-primary/5 transition-colors duration-200"
            >
                <div class="text-center">
                    <x-icon name="heroicon-o-cloud-arrow-up" class="w-16 h-16 text-muted-foreground mb-4 mx-auto" />
                    <p class="text-base font-medium text-foreground mb-2">{{ $placeholder }}</p>
                    @if($helpText)
                        <p class="text-sm text-muted-foreground mb-2">{{ $helpText }}</p>
                    @endif
                    <p class="text-sm text-muted-foreground">
                        Accepted formats: {{ str_replace(',', ', ', $accept) }}
                    </p>
                    <p class="text-sm text-muted-foreground">Max size: {{ $getMaxSizeFormatted() }}</p>
                </div>
            </div>
            
            <!-- File List -->
            <div x-show="(multiple && files && files.length > 0) || (!multiple && files)" x-transition class="space-y-2">
                <template x-for="file in multiple ? (files || []) : (files ? [files] : [])" :key="file ? getFileId(file) : 'empty'">
                    <div x-show="file" class="flex items-center gap-3 p-3 bg-card border border-border rounded-md">
                        <!-- File Icon/Preview -->
                        <div class="flex-shrink-0">
                            <template x-if="file && previews[getFileId(file)]">
                                <img :src="previews[getFileId(file)]" :alt="file.name" class="w-10 h-10 object-cover rounded" />
                            </template>
                            <template x-if="file && !previews[getFileId(file)]">
                                <div class="w-10 h-10 bg-muted rounded flex items-center justify-center">
                                    <div x-html="getFileIconHtml(file, 'w-5 h-5 text-muted-foreground')"></div>
                                </div>
                            </template>
                        </div>
                        
                        <!-- File Details -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-foreground truncate" x-text="getFileName(file)"></p>
                            <p class="text-xs text-muted-foreground" x-text="formatFileSize(getFileSize(file))"></p>
                            
                            <!-- Upload Progress -->
                            <div x-show="progress[getFileId(file)] !== undefined && progress[getFileId(file)] < 100" class="mt-1">
                                <div class="w-full bg-muted rounded-full h-1">
                                    <div class="bg-primary h-1 rounded-full transition-all duration-300" :style="`width: ${progress[getFileId(file)] || 0}%`"></div>
                                </div>
                            </div>
                            
                            <!-- Error Message -->
                            <div x-show="errors[getFileId(file)]" class="mt-1">
                                <p class="text-xs text-destructive" x-text="errors[getFileId(file)]"></p>
                            </div>
                        </div>
                        
                        <!-- Status & Actions -->
                        <div class="flex items-center gap-2">
                            <!-- Upload Complete -->
                            <div x-show="progress[getFileId(file)] === 100" class="text-primary">
                                <span class="text-lg text-accent">✓</span>
                            </div>
                            
                            <!-- Remove Button -->
                            <x-strata::button
                                type="button"
                                @click="removeFile(getFileId(file))"
                                variant="ghost"
                                size="sm"
                                icon="heroicon-o-trash"
                                class="!p-1.5 text-muted-foreground hover:text-destructive"
                            />
                        </div>
                    </div>
                </template>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('alpine:initializing', () => {
    /**
     * Strata File Upload Component
     * @param {Object} config - Configuration object
     * @returns {Object} Alpine component object
     */
    Alpine.data('strataFileUpload', (config) => ({
        files: config.multiple ? [] : null,
        dragOver: false,
        uploading: false,
        processingDrop: false,
        progress: {},
        previews: {},
        errors: {},
        
        // Configuration
        hasWireModel: config.hasWireModel,
        maxSize: config.maxSize,
        accept: config.accept,
        multiple: config.multiple,
        mediaLibrary: config.mediaLibrary,
        enableReordering: config.enableReordering,
        maxSizeFormatted: config.maxSizeFormatted,
        
        init() {
            // Initialize existing files if any
            this.initializeExistingFiles();
            
            // Always add change event listener for UI updates
            this.fileInputHandler = (e) => {
                // Skip if we're processing a drop (to avoid double processing)
                if (!this.processingDrop) {
                    this.handleFileSelection(e.target.files);
                }
            };
            this.$refs.fileInput.addEventListener('change', this.fileInputHandler);
        },
        
        destroy() {
            // Clean up event listeners and blob URLs
            if (this.fileInputHandler && this.$refs.fileInput) {
                this.$refs.fileInput.removeEventListener('change', this.fileInputHandler);
            }
            
            // Clean up blob URLs
            Object.values(this.previews).forEach(url => {
                if (url && typeof url === 'string' && url.startsWith('blob:')) {
                    URL.revokeObjectURL(url);
                }
            });
        },
        
        initializeExistingFiles() {
            if (this.files && Array.isArray(this.files)) {
                this.files.forEach(file => {
                    if (file.url && !this.previews[getFileId(file)]) {
                        this.previews[getFileId(file)] = file.url;
                    }
                });
            }
        },
        
        handleDragOver(e) {
            e.preventDefault();
            this.dragOver = true;
        },
        
        handleDragLeave(e) {
            e.preventDefault();
            if (!this.$el.contains(e.relatedTarget)) {
                this.dragOver = false;
            }
        },
        
        handleDrop(e) {
            e.preventDefault();
            this.dragOver = false;
            
            // For Livewire integration, we need to transfer files to the input
            if (this.$wire && this.hasWireModel) {
                this.processingDrop = true;
                
                const dataTransfer = new DataTransfer();
                Array.from(e.dataTransfer.files).forEach(file => {
                    dataTransfer.items.add(file);
                });
                
                // Update the file input and let Livewire handle it
                this.$refs.fileInput.files = dataTransfer.files;
                
                // Handle UI updates separately
                this.handleFileSelection(e.dataTransfer.files);
                
                // Reset flag after a brief delay to allow change event to be ignored
                setTimeout(() => {
                    this.processingDrop = false;
                }, 10);
            } else {
                this.handleFileSelection(e.dataTransfer.files);
            }
        },
        
        openFileBrowser() {
            this.$refs.fileInput.click();
        },
        
        handleFileSelection(fileList) {
            const files = Array.from(fileList);
            this.errors = {};
            
            // Validate files
            const validFiles = files.filter(file => this.validateFile(file));
            
            if (validFiles.length === 0) return;
            
            // For both Livewire and non-Livewire, just handle UI state
            // Let the actual file input and wire:model handle the data
            if (this.multiple) {
                validFiles.forEach(file => this.addFile(file));
            } else {
                // Single file mode - replace existing
                this.clearFiles();
                this.addFile(validFiles[0]);
            }
        },
        
        validateFile(file) {
            const fileId = this.generateFileId(file);
            
            // Check file size
            if (file.size > this.maxSize * 1024) {
                this.errors[fileId] = `File size exceeds ${this.maxSizeFormatted}`;
                return false;
            }
            
            // Check file type if accept is specified
            if (this.accept && this.accept !== '*/*') {
                const acceptedTypes = this.accept.split(',').map(type => type.trim());
                const isAccepted = acceptedTypes.some(type => {
                    if (type.startsWith('.')) {
                        return file.name.toLowerCase().endsWith(type.toLowerCase());
                    }
                    if (type.includes('/*')) {
                        const mimeCategory = type.split('/')[0];
                        return file.type.startsWith(mimeCategory);
                    }
                    return file.type === type;
                });
                
                if (!isAccepted) {
                    this.errors[fileId] = 'File type not accepted';
                    return false;
                }
            }
            
            return true;
        },
        
        generateFileId(file) {
            return file.name + '_' + file.size + '_' + file.lastModified;
        },
        
        addFile(file) {
            const fileId = this.generateFileId(file);
            
            // Create preview for images
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previews[fileId] = e.target.result;
                };
                reader.readAsDataURL(file);
            }
            
            // For Livewire integration, only manage UI state
            if (this.$wire && this.hasWireModel) {
                // Create UI-only file objects for display purposes
                const uiFileObject = {
                    id: fileId,
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    file: file,
                    uploaded: false // Will be managed by Livewire
                };
                
                if (this.multiple) {
                    if (!Array.isArray(this.files)) {
                        this.files = [];
                    }
                    this.files.push(uiFileObject);
                } else {
                    this.files = uiFileObject;
                }
                
                // Livewire will handle the actual file upload automatically
                // We just need to trigger the file input change event
                // The wire:model on the input will sync with Livewire
                
            } else {
                // For non-Livewire usage, use custom file objects
                const fileObject = {
                    id: fileId,
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    file: file,
                    uploaded: false
                };
                
                if (this.multiple) {
                    if (!Array.isArray(this.files)) {
                        this.files = [];
                    }
                    this.files.push(fileObject);
                } else {
                    this.files = fileObject;
                }
                
                // Start simulated upload for non-Livewire usage
                this.uploadFile(fileObject);
            }
        },
        
        uploadFile(fileObject) {
            this.uploading = true;
            this.progress[fileObject.id] = 0;
            
            // Simulate upload progress for demo purposes
            // In real implementation, this would be handled by Livewire
            const interval = setInterval(() => {
                if (this.progress[fileObject.id] < 90) {
                    this.progress[fileObject.id] += Math.random() * 20;
                } else {
                    this.progress[fileObject.id] = 100;
                    fileObject.uploaded = true;
                    this.uploading = false;
                    clearInterval(interval);
                }
            }, 200);
        },
        
        removeFile(fileId) {
            if (this.multiple && Array.isArray(this.files)) {
                this.files = this.files.filter(file => this.getFileId(file) !== fileId);
            } else {
                this.files = null;
            }
            
            // Clean up preview
            if (this.previews[fileId] && this.previews[fileId].startsWith('blob:')) {
                URL.revokeObjectURL(this.previews[fileId]);
            }
            delete this.previews[fileId];
            delete this.progress[fileId];
            delete this.errors[fileId];
            
            // Clear the file input to allow re-selection of the same file
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = '';
            }
        },
        
        clearFiles() {
            if (Array.isArray(this.files)) {
                this.files.forEach(file => {
                    const fileId = this.getFileId(file);
                    if (this.previews[fileId] && this.previews[fileId].startsWith('blob:')) {
                        URL.revokeObjectURL(this.previews[fileId]);
                    }
                });
            }
            this.files = this.multiple ? [] : null;
            this.previews = {};
            this.progress = {};
            this.errors = {};
            
            // Clear the file input to allow re-selection
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = '';
            }
        },
        
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },
        
        getFileIconName(file) {
            const fileType = this.getFileType(file);
            if (fileType.startsWith('image/')) return 'heroicon-o-photo';
            if (fileType === 'application/pdf') return 'heroicon-o-document-text';
            if (fileType.includes('word') || this.getFileName(file).endsWith('.doc') || this.getFileName(file).endsWith('.docx')) return 'heroicon-o-document-text';
            if (fileType.includes('spreadsheet') || this.getFileName(file).endsWith('.xls') || this.getFileName(file).endsWith('.xlsx')) return 'heroicon-o-table-cells';
            if (fileType.startsWith('video/')) return 'heroicon-o-video-camera';
            if (fileType.startsWith('audio/')) return 'heroicon-o-musical-note';
            return 'heroicon-o-document';
        },

        getFileIconHtml(file, classes = 'w-6 h-6') {
            const iconName = this.getFileIconName(file);
            // Return appropriate Heroicon SVG based on icon name
            const icons = {
                'heroicon-o-photo': `<svg class="${classes}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 3a3 3 0 00-3 3v2.25a3 3 0 003 3h2.25a3 3 0 003-3V6a3 3 0 00-3-3H6zM15.75 3a3 3 0 013 3v2.25a3 3 0 01-3 3H13.5a3 3 0 01-3-3V6a3 3 0 013-3h2.25zM6 12.75a3 3 0 00-3 3V18a3 3 0 003 3h2.25a3 3 0 003-3v-2.25a3 3 0 00-3-3H6zM15.75 12.75a3 3 0 013 3V18a3 3 0 01-3 3H13.5a3 3 0 01-3-3v-2.25a3 3 0 013-3h2.25z"></path></svg>`,
                'heroicon-o-document-text': `<svg class="${classes}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5-3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0-1.125.504-1.125 1.125V11.25a9 9 0 00-9-9z"></path></svg>`,
                'heroicon-o-table-cells': `<svg class="${classes}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625v1.5c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-12.75c0-.621-.504-1.125-1.125-1.125m0 0V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m-1.125 1.125v-1.5c0-.621.504-1.125 1.125-1.125m0 0h7.5"></path></svg>`,
                'heroicon-o-video-camera': `<svg class="${classes}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"></path></svg>`,
                'heroicon-o-musical-note': `<svg class="${classes}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"></path></svg>`,
                'heroicon-o-document': `<svg class="${classes}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path></svg>`
            };
            return icons[iconName] || icons['heroicon-o-document'];
        },
        
        // Helper methods to handle both File objects and custom file objects
        getFileName(file) {
            return file.name || (file.file ? file.file.name : 'Unknown');
        },
        
        getFileSize(file) {
            return file.size || (file.file ? file.file.size : 0);
        },
        
        getFileType(file) {
            return file.type || (file.file ? file.file.type : '');
        },
        
        getFileId(file) {
            if (file.id) return file.id;
            if (file.name && file.size && file.lastModified) {
                return this.generateFileId(file);
            }
            return this.getFileName(file) + '_' + this.getFileSize(file);
        }
    }));
});
</script>