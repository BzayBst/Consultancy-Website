<div class="blog-admin-wrap" x-data>
    <div class="blog-admin-header">
        <div>
            <h1>Blog Posts</h1>
            <p>Manage frontend blog articles and detail page content.</p>
        </div>
        <div class="blog-admin-actions">
            <a href="{{ route('blog') }}" target="_blank" class="btn-preview">Preview Blog</a>
            <button wire:click="openCreate" class="btn-add">+ Add Post</button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="blog-filters">
        <div class="blog-search">
            <span>Search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Title, category, excerpt">
        </div>
        <select wire:model.live="filterActive">
            <option value="">All Visibility</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="trashed">Trashed</option>
        </select>
        <select wire:model.live="perPage">
            <option value="10">10 / page</option>
            <option value="20">20 / page</option>
            <option value="50">50 / page</option>
        </select>
    </div>

    <div class="post-list">
        @forelse($posts as $post)
            <div class="post-row {{ $post->trashed() ? 'is-trashed' : '' }}">
                <div class="post-thumb">
                    @if($post->image_url)
                        <img src="{{ $post->image_url }}" alt="{{ $post->image_alt ?: $post->title }}">
                    @else
                        <div class="thumb-placeholder">Blog</div>
                    @endif
                </div>
                <div class="post-main">
                    <div class="post-meta">
                        @if($post->category)<span>{{ $post->category }}</span>@endif
                        <span>{{ $post->published_at?->format('d M Y') ?: 'Draft date' }}</span>
                        @if($post->is_featured)<span>Featured</span>@endif
                    </div>
                    <h3>{{ $post->title }}</h3>
                    @if($post->excerpt)<p>{{ Str::limit($post->excerpt, 140) }}</p>@endif
                </div>
                <div class="post-actions">
                    @if($post->trashed())
                        <span class="trashed-label">Trashed</span>
                        <button wire:click="confirmRestore({{ $post->id }})" class="btn-restore">Restore</button>
                    @else
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn-view">View</a>
                        <button wire:click="toggleActive({{ $post->id }})" class="btn-toggle {{ $post->is_active ? 'on' : 'off' }}">
                            {{ $post->is_active ? 'Visible' : 'Hidden' }}
                        </button>
                        <button wire:click="openEdit({{ $post->id }})" class="btn-edit">Edit</button>
                        <button wire:click="confirmDelete({{ $post->id }})" class="btn-delete">Delete</button>
                    @endif
                </div>
            </div>
        @empty
            <div class="post-empty">
                <strong>No blog posts yet.</strong>
                <span>Create the first article to populate the frontend blog.</span>
            </div>
        @endforelse
    </div>

    @if($posts->hasPages())
        <div class="blog-pagination">{{ $posts->links() }}</div>
    @endif

    @if($showModal)
        <div class="modal-backdrop" x-on:keydown.escape.window="$wire.closeModal()">
            <div class="modal-box" @click.outside="$wire.closeModal()">
                <div class="modal-head">
                    <h2>{{ $isEdit ? 'Edit Blog Post' : 'Add Blog Post' }}</h2>
                    <button wire:click="closeModal" class="modal-close">x</button>
                </div>

                <form wire:submit="save">
                    <div class="modal-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Title <span>*</span></label>
                                <input type="text" wire:model.live="title" placeholder="Study abroad guide">
                                @error('title') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" wire:model.live="slug" placeholder="study-abroad-guide">
                                @error('slug') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" wire:model.live="category" placeholder="Study Guide">
                                @error('category') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Publish Date</label>
                                <input type="date" wire:model.live="published_at">
                                @error('published_at') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" min="0" wire:model.live="sort_order">
                                @error('sort_order') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group check-pair">
                                <label><input type="checkbox" wire:model.live="is_active"> Visible</label>
                                <label><input type="checkbox" wire:model.live="is_featured"> Featured</label>
                            </div>
                            <div class="form-group full">
                                <label>Excerpt</label>
                                <textarea wire:model.live="excerpt" rows="3" placeholder="Short summary used on cards and meta description"></textarea>
                                @error('excerpt') <small>{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="upload-row">
                            <label class="upload-box">
                                @if($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" alt="Preview">
                                @elseif($existingPhoto)
                                    <img src="{{ str_starts_with($existingPhoto, 'http') ? $existingPhoto : asset('storage/' . $existingPhoto) }}" alt="Current image">
                                @else
                                    <div>
                                        <strong>Upload featured image</strong>
                                        <span>JPG, PNG or WebP up to 3MB</span>
                                    </div>
                                @endif
                                <input type="file" wire:model="photo" accept="image/png,image/jpeg,image/webp">
                            </label>
                            @error('photo') <small class="upload-error">{{ $message }}</small> @enderror
                            <div wire:loading wire:target="photo" class="uploading">Uploading image...</div>
                            @if($existingPhoto && ! $photo)
                                <label class="remove-photo"><input type="checkbox" wire:model.live="removePhoto"> Remove current image</label>
                            @endif
                        </div>

                        <div class="form-group full editor-box" wire:ignore>
                            <label>Detail Content</label>
                            <div class="editor-toolbar">
                                <button type="button" data-insert="<h2>Heading</h2>">H2</button>
                                <button type="button" data-wrap="<strong>|</strong>">Bold</button>
                                <button type="button" data-wrap="<em>|</em>">Italic</button>
                                <button type="button" data-insert="<p>Write your paragraph here.</p>">Paragraph</button>
                                <button type="button" data-insert="<ul><li>First point</li><li>Second point</li></ul>">List</button>
                                <button type="button" data-insert="<blockquote>Important note or quote.</blockquote>">Quote</button>
                            </div>
                            <textarea id="blogContentEditor" rows="12" placeholder="<p>Write the full blog detail here...</p>">{{ $content }}</textarea>
                            <div class="editor-hint">Use the toolbar or write HTML directly. This content renders on the blog detail page.</div>
                            @error('content') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="form-grid seo-grid">
                            <div class="form-group">
                                <label>Meta Title</label>
                                <input type="text" wire:model.live="meta_title" placeholder="Optional SEO title">
                                @error('meta_title') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Image Alt Text</label>
                                <input type="text" wire:model.live="image_alt" placeholder="Students at seminar">
                                @error('image_alt') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group full">
                                <label>Meta Description</label>
                                <textarea wire:model.live="meta_description" rows="2" placeholder="Optional SEO description"></textarea>
                                @error('meta_description') <small>{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-foot">
                        <button type="button" wire:click="closeModal" class="btn-cancel">Cancel</button>
                        <button type="submit" class="btn-save" wire:loading.attr="disabled" onclick="syncBlogEditor()">
                            {{ $isEdit ? 'Update Post' : 'Create Post' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($confirmingDeleteId)
        <div class="modal-backdrop">
            <div class="confirm-box">
                <h2>Delete post?</h2>
                <p>This moves the post to trash. You can restore it later.</p>
                <div>
                    <button wire:click="cancelDelete" class="btn-cancel">Cancel</button>
                    <button wire:click="delete" class="btn-confirm-delete">Delete</button>
                </div>
            </div>
        </div>
    @endif

    @if($confirmingRestoreId)
        <div class="modal-backdrop">
            <div class="confirm-box">
                <h2>Restore post?</h2>
                <p>This returns the post to the blog manager.</p>
                <div>
                    <button wire:click="cancelRestore" class="btn-cancel">Cancel</button>
                    <button wire:click="restore" class="btn-confirm-restore">Restore</button>
                </div>
            </div>
        </div>
    @endif

    <script>
        function syncBlogEditor() {
            const editor = document.getElementById('blogContentEditor');
            if (editor) @this.set('content', editor.value);
        }

        document.addEventListener('click', function (event) {
            const button = event.target.closest('.editor-toolbar button');
            const editor = document.getElementById('blogContentEditor');
            if (!button || !editor) return;

            const start = editor.selectionStart;
            const end = editor.selectionEnd;
            const selected = editor.value.slice(start, end);
            let insert = button.dataset.insert || '';

            if (button.dataset.wrap) {
                insert = button.dataset.wrap.replace('|', selected || 'text');
            }

            editor.value = editor.value.slice(0, start) + insert + editor.value.slice(end);
            editor.focus();
            editor.setSelectionRange(start + insert.length, start + insert.length);
            @this.set('content', editor.value);
        });

        document.addEventListener('input', function (event) {
            if (event.target?.id === 'blogContentEditor') {
                @this.set('content', event.target.value);
            }
        });
    </script>
</div>

<style>
.blog-admin-wrap{padding:24px}
.blog-admin-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px}
.blog-admin-header h1{font-family:'Playfair Display',serif;font-size:28px;color:var(--navy);margin:0 0 4px}
.blog-admin-header p{color:var(--text);font-size:14px;margin:0}
.blog-admin-actions{display:flex;gap:10px;flex-wrap:wrap}
.btn-preview,.btn-add{border:none;border-radius:8px;padding:10px 16px;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer}
.btn-preview{background:#fff;color:var(--navy);border:1px solid var(--border)}
.btn-add{background:var(--navy);color:#fff}
.alert-success{background:#dcfce7;color:#166534;border:1px solid #bbf7d0;border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:14px}
.blog-filters{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-bottom:18px}
.blog-search{flex:1;min-width:240px;background:#fff;border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;gap:10px;padding:9px 12px}
.blog-search span{font-size:12px;font-weight:700;color:var(--navy)}
.blog-search input{flex:1;border:none;outline:none;font:inherit;background:transparent}
.blog-filters select{background:#fff;border:1px solid var(--border);border-radius:8px;padding:10px 12px;font:inherit;color:#333}
.post-list{display:flex;flex-direction:column;gap:12px}
.post-row{background:#fff;border:1px solid var(--border);border-radius:10px;padding:12px;display:grid;grid-template-columns:130px 1fr auto;gap:14px;align-items:center;box-shadow:0 4px 14px rgba(15,23,42,.05)}
.post-row.is-trashed{opacity:.65;background:#fff5f5}
.post-thumb{aspect-ratio:16/10;background:#e2e8f0;border-radius:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;color:#64748b;font-weight:700}
.post-thumb img{width:100%;height:100%;object-fit:cover}
.post-meta{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:6px}
.post-meta span{background:#f1f5f9;border-radius:999px;padding:3px 8px;font-size:11px;color:#64748b}
.post-main h3{font-size:16px;color:var(--navy);margin:0 0 5px}
.post-main p{font-size:13px;color:var(--text);line-height:1.45;margin:0}
.post-actions{display:flex;gap:6px;align-items:center;justify-content:flex-end;flex-wrap:wrap}
.post-actions button,.post-actions a{border:none;border-radius:7px;padding:7px 10px;font-size:12px;font-weight:700;cursor:pointer;text-decoration:none}
.btn-view,.btn-edit{background:#e8edfd;color:var(--blue)}
.btn-toggle.on{background:#dcfce7;color:#166534}
.btn-toggle.off,.btn-delete{background:#fee2e2;color:#991b1b}
.btn-restore,.btn-confirm-restore{background:#dcfce7;color:#166534}
.trashed-label{color:#991b1b;font-size:12px;font-weight:700}
.post-empty,.blog-pagination{background:#fff;border:1px dashed var(--border);border-radius:10px;padding:32px;text-align:center;color:#64748b}
.post-empty strong{display:block;color:var(--navy);margin-bottom:4px}
.blog-pagination{border-style:solid;margin-top:18px;padding:12px 16px;text-align:left}
.modal-backdrop{position:fixed;inset:0;z-index:1000;background:rgba(13,21,96,.45);display:flex;align-items:center;justify-content:center;padding:20px}
.modal-box,.confirm-box{background:#fff;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.25);width:100%}
.modal-box{max-width:920px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column}
.modal-box form{display:flex;flex-direction:column;min-height:0;flex:1}
.confirm-box{max-width:380px;padding:24px;text-align:center}
.confirm-box h2,.modal-head h2{font-family:'Playfair Display',serif;color:var(--navy);font-size:20px;margin:0}
.confirm-box p{color:var(--text);font-size:14px;line-height:1.5;margin:10px 0 18px}
.modal-head,.modal-foot{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 20px;border-bottom:1px solid var(--border)}
.modal-foot{justify-content:flex-end;border-top:1px solid var(--border);border-bottom:0}
.modal-close{border:none;background:#f1f5f9;border-radius:6px;width:30px;height:30px;cursor:pointer;color:var(--navy)}
.modal-body{padding:20px;overflow-y:auto;min-height:0;flex:1}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-group{display:flex;flex-direction:column;gap:6px}
.form-group.full{grid-column:1/-1}
.form-group label{color:var(--navy);font-size:13px;font-weight:700}
.form-group label span,.form-group small,.upload-error{color:var(--red)}
.form-group input,.form-group textarea,#blogContentEditor{border:1.5px solid var(--border);border-radius:8px;padding:10px 12px;font:inherit;outline:none;width:100%}
.form-group input:focus,.form-group textarea:focus,#blogContentEditor:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1)}
.check-pair{flex-direction:row;align-items:center;gap:18px;padding-top:27px}
.check-pair label{display:flex;align-items:center;gap:7px}
.upload-row{margin:16px 0}
.upload-box{border:2px dashed var(--border);border-radius:10px;min-height:210px;display:flex;align-items:center;justify-content:center;text-align:center;cursor:pointer;overflow:hidden;position:relative;background:#f8fafc}
.upload-box:hover{border-color:var(--blue);background:#eef3ff}
.upload-box img{width:100%;height:250px;object-fit:contain;padding:10px}
.upload-box input{position:absolute;inset:0;opacity:0;cursor:pointer}
.upload-box strong{display:block;color:var(--navy);margin-bottom:4px}
.upload-box span,.uploading,.editor-hint{color:#64748b;font-size:12px}
.remove-photo{display:flex;align-items:center;gap:8px;margin-top:10px;color:var(--navy);font-size:13px;font-weight:600}
.editor-box{margin:18px 0}
.editor-toolbar{display:flex;gap:7px;flex-wrap:wrap;background:#f8fafc;border:1px solid var(--border);border-radius:8px 8px 0 0;padding:8px}
.editor-toolbar button{border:1px solid var(--border);background:#fff;color:var(--navy);border-radius:6px;padding:6px 9px;font-size:12px;font-weight:700;cursor:pointer}
#blogContentEditor{border-radius:0 0 8px 8px;font-family:Consolas,monospace;line-height:1.6}
.seo-grid{margin-top:18px}
.btn-cancel,.btn-save,.btn-confirm-delete,.btn-confirm-restore{border:none;border-radius:8px;padding:10px 16px;font-size:13px;font-weight:700;cursor:pointer}
.btn-cancel{background:#f1f5f9;color:var(--navy)}
.btn-save,.btn-confirm-delete{background:var(--red);color:#fff}
@media(max-width:800px){.blog-admin-header{align-items:flex-start;flex-direction:column}.post-row{grid-template-columns:1fr}.post-actions{justify-content:flex-start}.form-grid{grid-template-columns:1fr}.check-pair{padding-top:0}}
</style>
