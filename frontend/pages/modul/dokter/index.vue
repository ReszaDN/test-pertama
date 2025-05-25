<template>
    <h3>Daftar Pasien</h3>
    <fwb-table>
      <fwb-table-head>

        <fwb-table-head-cell>Nama Pasien</fwb-table-head-cell>
        <fwb-table-head-cell>Tgl_lahir</fwb-table-head-cell>
        <fwb-table-head-cell>Jenis Kelamin</fwb-table-head-cell>
        <fwb-table-head-cell>no_tlp</fwb-table-head-cell>
        <fwb-table-head-cell>#</fwb-table-head-cell>
      </fwb-table-head>
      <fwb-table-body>
        <fwb-table-row v-for="(list, index) in listPasien">
          <fwb-table-cell>{{ list.nama }}</fwb-table-cell>
          <fwb-table-cell>{{ list.tgl_lahir }}</fwb-table-cell>
          <fwb-table-cell>{{ list.jenis_kelamin }}</fwb-table-cell>
          <fwb-table-cell>{{ list.no_tlp }}</fwb-table-cell>
          <fwb-table-cell>
            <fwb-button style="background: green;" @click="showModal(list.id)">Periksa</fwb-button>
          </fwb-table-cell>
        </fwb-table-row>
      </fwb-table-body>
    </fwb-table>

    <template>
      
    </template>
    <div style="align-items: center;">
      <fwb-modal v-if="isShowModal" @close="closeModal" class="max-w-2xl" position="center">
        <template #header>
          <div class="flex items-center text-lg">
            Masukan Hasil Pemeriksaan
          </div>
        </template>
        <template #body>
        <!-- <p class="text-white text-sm mb-2">UUID Pasien: {{ uuidPasien  }}</p> -->

        <fwb-input v-model="tekananDarah" label="Tekanan Darah" placeholder="Tekanan Darah" size="sm" disabled/>
        <fwb-input v-model="beratBadan" label="Berat Badan" placeholder="Berat Badan" size="sm" disabled/>
        <fwb-input v-model="keluhan" label="Keluhan" placeholder="Keluhan" size="sm" />
        <fwb-input v-model="diagnosa" label="Diagnosa" placeholder="Diagnosa" size="sm" />
        </template>
        <template #footer>
          <div class="flex justify-between">
            <fwb-button @click="simpanPemeriksaan" color="green">
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
  const tekananDarah = ref("");
  const beratBadan = ref("");
  const uuidPasien = ref("")
  const keluhan = ref("")
  const diagnosa = ref("")


   onMounted(()=> {
    getPasien()
  })

  function getPasien(){
      fetch.get("http://localhost:8000/api/" + 'pasien-list').then((response)=> {
        console.log(response)
        listPasien.value = response.data
      })
  }

  async function simpanPemeriksaan() {
  try {
      // Siapkan payload untuk pengiriman data
      const payload = {
        uuid_pasien: uuidPasien.value,
        tekanan_darah: tekananDarah.value,
        berat_badan: beratBadan.value,
        keluhan: keluhan.value,
        diagnosa: diagnosa.value
      };

      const response = await fetch.put(
        "http://localhost:8000/api/" + 'post-dokter',
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


  async function getPemeriksaan(uuid) {
  try {
    const response = await fetch.get("http://localhost:8000/api/pemeriksaan/" + uuid);
    console.log("Response pemeriksaan:", response);

    if (response.success && response.data) {
      tekananDarah.value = response.data.td;
      beratBadan.value = response.data.bb;
      keluhan.value = response.data.keluhan;
      diagnosa.value = response.data.diagnosa;
    } else {
      alert("Perawat Belum Melakukan Pemeriksaan");
      closeModal();
    }
  } catch (error) {
    console.error("Gagal mengambil data pemeriksaan:", error);
    tekananDarah.value = "";
    beratBadan.value = "";
  }
}


  const isShowModal = ref(false)

  function closeModal() {
    isShowModal.value = false;
    tekananDarah.value = "";
    beratBadan.value = "";
    keluhan.value = "";
    diagnosa.value = "";
  }

  function showModal (id) {
    isShowModal.value = true
    uuidPasien.value = id

    getPemeriksaan(id);
    isShowModal.value = true;
  }
</script>
