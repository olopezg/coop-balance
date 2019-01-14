<template>
  <div class="simple">
    <div class="upload">
      <ul>
        <li style="list-style:none" v-for="file in files" :key="file.id">
          <span>{{file.name + " "}}</span>
          <span v-if="file.error">{{file.error}}</span>
          <span v-else-if="file.success">success</span>
          <span v-else-if="file.active">active</span>
          <span v-else-if="file.active">active</span>
          <span v-else></span>
        </li>
      </ul>
      <div>
        <file-upload
          class="btn btn-primary"
          :post-action="'/file'"
          extensions
          accept
          :multiple="true"
          :size="1024 * 1024 * 10"
          v-model="files"
          @input-filter="inputFilter"
          @input-file="inputFile"
          ref="upload"
          :headers="{'X-CSRF-TOKEN': csrf_token}"
        >
          <i class="fa fa-plus"></i>
          Select files
        </file-upload>
        <button
          type="button"
          class="btn btn-success"
          v-if="!$refs.upload || !$refs.upload.active"
          @click.prevent="$refs.upload.active = true"
        >
          <i class="fa fa-arrow-up" aria-hidden="true"></i>
          Start Upload
        </button>
        <button
          type="button"
          class="btn btn-danger"
          v-else
          @click.prevent="$refs.upload.active = false"
        >
          <i class="fa fa-stop" aria-hidden="true"></i>
          Stop Upload
        </button>
        
        <button type="button" class="btn btn-warning" @click="files = []">Clear</button>
      </div>
    </div>
  </div>
</template>

<script>
import FileUpload from "vue-upload-component";

export default {
  name: "simple-upload",
  components: {
    FileUpload
  },
  data() {
    return {
      files: [],
      csrf_token: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    };
  },
  methods: {
    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Before adding a file

        // Filter system files or hide files

        if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
          return prevent();
        }
        // Filter php html js file

        if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
          return prevent();
        }
      }
    },
    inputFile(newFile, oldFile) {
      this.$emit("files", newFile);
    }
  }
};
</script>

<style>
.simple label.btn {
  margin-bottom: 0;
  margin-right: 1rem;
}
</style>