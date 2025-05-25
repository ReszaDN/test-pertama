<template>
    <h3>Daftar Pasien</h3>
    <fwb-button @click="showModal">Tambah Pasien</fwb-button>
    <fwb-table>
      <fwb-table-head>
        <!-- <fwb-table-head-cell>Nama Pasien</fwb-table-head-cell> -->
        <fwb-table-head-cell>Nama Pasien</fwb-table-head-cell>
        <fwb-table-head-cell>Tgl_lahir</fwb-table-head-cell>
        <fwb-table-head-cell>Jenis Kelamin</fwb-table-head-cell>
        <fwb-table-head-cell>no_tlp</fwb-table-head-cell>
        <!-- <fwb-table-head-cell>#</fwb-table-head-cell> -->
      </fwb-table-head>
      <fwb-table-body>
        <fwb-table-row v-for="(list, index) in listPasien">
          <!-- <fwb-table-cell>{{ index + 1 }}</fwb-table-cell> -->
          <fwb-table-cell>{{ list.nama }}</fwb-table-cell>
          <fwb-table-cell>{{ list.tgl_lahir }}</fwb-table-cell>
          <fwb-table-cell>{{ list.jenis_kelamin }}</fwb-table-cell>
          <fwb-table-cell>{{ list.no_tlp }}</fwb-table-cell>
          <!-- <fwb-table-cell>
            <fwb-button style="background: red;" @click="hapusKota(list.uuid)">Hapus</fwb-button>
          </fwb-table-cell> -->
        </fwb-table-row>
      </fwb-table-body>
    </fwb-table>

    <template>
      
    </template>
    <div style="align-items: center;">
      <fwb-modal v-if="isShowModal" @close="closeModal" class="max-w-2xl" position="center">
        <template #header>
          <div class="flex items-center text-lg">
            Registrasi Pasien
          </div>
        </template>
        <template #body>
          <fwb-input v-model="namaPasien" label="Nama Pasien" placeholder="enter your name" size="sm" />
          <fwb-input v-model="tglLahir" type="date" label="Tanggal Lahir"size="sm"/>
          <label class="block text-white text-sm mb-1">Jenis Kelamin</label>
          <div class="mb-2">
            <select v-model="jenisKelamin" class="bg-gray-800 text-white p-2 rounded w-full">
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          <fwb-input v-model="noTlp" label="No. Tlp" placeholder="enter your name" size="sm" />
        </template>
        <template #footer>
          <div class="flex justify-between">
            <fwb-button @click="tambahPasien" color="green">
              Simpan
            </fwb-button>
          </div>
        </template>
      </fwb-modal>
    </div>
      
  </template>

<script setup>
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbButton,
    FwbModal,
    FwbInput,
    FwbSelect, 
  } from 'flowbite-vue'
  import { fetch } from "~/utils/fetchWrapper";
  import {ref} from "vue";

  const listPasien = ref([]);
  const namaPasien = ref("");
  const tglLahir = ref("");
  const jenisKelamin = ref("");
  const noTlp = ref("");


   onMounted(()=> {
    getPasien()
  })

  function getPasien(){
      fetch.get("http://localhost:8000/api/" + 'pasien-list').then((response)=> {
        console.log(response)
        listPasien.value = response.data
      })
  }

  async function tambahPasien() {
  try {
      const payload = {
        nama: namaPasien.value,
        tgl_lahir: tglLahir.value,
        jenis_kelamin: jenisKelamin.value,
        no_hp: noTlp.value,
      };

      const response = await fetch.post(
        "http://localhost:8000/api/" + 'tambah-pasien',
        payload
      );

      if (response.success) {
        closeModal();
        getPasien();
      }
    } catch (error) {
      console.error("Error:", error);
      alert("Terjadi kesalahan saat menyimpan data.");
    }
  }


  const isShowModal = ref(false)

  function closeModal () {
    isShowModal.value = false
  }
  function showModal () {
    isShowModal.value = true
  }
</script>
