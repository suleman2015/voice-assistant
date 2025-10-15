import { createApp, ref, onMounted } from 'vue'
import axios from 'axios'

const MediaApp = {
  setup() {
    const files = ref([])
    const folders = ref([])
    const currentFolder = ref('/')
    const newFolderName = ref('')

    const loadMedia = async () => {
      const res = await axios.get('/admin/media/list', {
        params: { folder: currentFolder.value }
      })
      files.value = res.data.files
      folders.value = res.data.folders
    }

    const handleUpload = async (event) => {
      const file = event.target.files[0]
      if (!file) return
      const form = new FormData()
      form.append('file', file)
      form.append('folder', currentFolder.value)
      await axios.post('/admin/media/upload', form)
      await loadMedia()
    }

    const handleDrop = async (event) => {
      const file = event.dataTransfer.files[0]
      if (!file) return
      const form = new FormData()
      form.append('file', file)
      form.append('folder', currentFolder.value)
      await axios.post('/admin/media/upload', form)
      await loadMedia()
    }

    const createFolder = async () => {
      if (!newFolderName.value.trim()) return
      await axios.post('/admin/media/folder', {
        name: newFolderName.value,
        folder: currentFolder.value
      })
      newFolderName.value = ''
      await loadMedia()
      bootstrap.Modal.getInstance(document.getElementById('createFolderModal')).hide()
    }

    const remove = async (path) => {
      if (!confirm('Are you sure you want to delete this file?')) return
      await axios.delete('/admin/media/file', { data: { path } })
      await loadMedia()
    }

    const download = (path) => {
      const anchor = document.createElement('a')
      anchor.href = `/storage/${path.replace('public/', '')}`
      anchor.download = ''
      anchor.click()
    }

    const copyLink = (url) => {
      navigator.clipboard.writeText(url)
      alert('Copied to clipboard!')
    }

    const navigate = (folder) => {
      currentFolder.value += `${folder}/`
      loadMedia()
    }

    onMounted(loadMedia)

    return {
      files,
      folders,
      currentFolder,
      loadMedia,
      handleUpload,
      handleDrop,
      createFolder,
      remove,
      download,
      copyLink,
      newFolderName,
      navigate
    }
  },

  template: `
    <div class="container mt-4" @dragover.prevent @drop.prevent="handleDrop">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Media Manager</h4>
        <div>
          <button class="btn btn-outline-primary me-2" @click="$refs.fileInput.click()">Upload</button>
          <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#createFolderModal">New Folder</button>
          <input type="file" ref="fileInput" class="d-none" @change="handleUpload" />
        </div>
      </div>

      <div class="row">
        <div v-for="folder in folders" class="col-md-2 text-center mb-3">
          <div class="folder-box" @click="navigate(folder)">
            📁 {{ folder }}
          </div>
        </div>

        <div v-for="file in files" class="col-md-2 text-center mb-3">
          <img :src="file.url" class="img-thumbnail" width="100">
          <small>{{ file.name }}</small>
          <div class="dropdown mt-1">
            <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">⋮</button>
            <ul class="dropdown-menu">
              <li><a @click.prevent="copyLink(file.url)" class="dropdown-item">Copy URL</a></li>
              <li><a @click.prevent="download(file.path)" class="dropdown-item">Download</a></li>
              <li><a @click.prevent="remove(file.path)" class="dropdown-item text-danger">Delete</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Folder Modal -->
      <div class="modal fade" id="createFolderModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header"><h5>Create Folder</h5></div>
            <div class="modal-body">
              <input type="text" class="form-control" v-model="newFolderName" placeholder="Folder name">
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" @click="createFolder">Create</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  `
}

createApp(MediaApp).mount('#media-app')
