import React, { useState } from "react";
import axios from "../axios/link";
import { useForm } from "react-hook-form";
import useGet from "../hook/useGet"; // ⬅️ import custom hook

const Kategori = () => {
  // React Hook Form setup
  const { register, handleSubmit, reset, setValue, formState: { errors } } = useForm();
  // Ambil data kategori dari API menggunakan custom hook
  const { isi, setIsi } = useGet("/kategori");
  const [pesan, setPesan] = useState("");
  const [idkategori, setIdkategori] = useState("");
  const [pilihan, setPilihan] = useState("tambah");

  // Refresh data kategori dari API
  const refreshData = async () => {
    try {
      const response = await axios.get("/kategori");
      setIsi(response.data);
    } catch (error) {
      console.error("Error refreshing data:", error);
    }
  };

  // Hapus kategori
  const hapus = async (id) => {
    if (window.confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      try {
        const response = await axios.delete(`/kategori/${id}`);
        setPesan(response.data.pesan);
        refreshData();
      } catch (error) {
        console.error("Error deleting kategori:", error);
      }
    }
  };

  // Submit form tambah/ubah kategori
  const onSubmit = async (data) => {
    try {
      if (pilihan === "tambah") {
        const response = await axios.post("/kategori", data);
        setPesan(response.data.pesan);
      } else {
        const response = await axios.put(`/kategori/${idkategori}`, data);
        setPesan(response.data.pesan);
        setPilihan("tambah");
        setIdkategori("");
      }
      reset();
      refreshData();
    } catch (error) {
      console.error("Error submitting form:", error);
    }
  };

  // Isi form untuk edit data
  const editData = (item) => {
    setValue("kategori", item.kategori);
    setValue("keterangan", item.keterangan);
    setIdkategori(item.idkategori);
    setPilihan("ubah");
  };

  return (
    <div className="container py-3">
      {/* Judul */}
      <div className="row mb-3">
        <div className="col">
          <h3 className="fw-bold text-primary">Data Kategori</h3>
        </div>
      </div>

      {/* Pesan sukses */}
      {pesan && (
        <div className="alert alert-success alert-dismissible fade show" role="alert">
          {pesan}
          <button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"
            onClick={() => setPesan("")}></button>
        </div>
      )}

      {/* Form tambah/ubah kategori */}
      <div className="card shadow-sm mb-4">
        <div className="card-header bg-primary text-white">
          {pilihan === "tambah" ? "Tambah Kategori" : "Ubah Kategori"}
        </div>
        <div className="card-body">
          <form onSubmit={handleSubmit(onSubmit)} className="row g-3">
            <div className="col-md-6">
              <label className="form-label">Kategori</label>
              <input
                type="text"
                className={`form-control ${errors.kategori ? 'is-invalid' : ''}`}
                {...register("kategori", { required: "Kategori harus diisi" })}
                placeholder="Masukkan nama kategori"
              />
              {errors.kategori && (
                <div className="invalid-feedback">{errors.kategori.message}</div>
              )}
            </div>
            <div className="col-md-6">
              <label className="form-label">Keterangan</label>
              <input
                type="text"
                className={`form-control ${errors.keterangan ? 'is-invalid' : ''}`}
                {...register("keterangan", { required: "Keterangan harus diisi" })}
                placeholder="Masukkan keterangan"
              />
              {errors.keterangan && (
                <div className="invalid-feedback">{errors.keterangan.message}</div>
              )}
            </div>
            <div className="col-12 d-flex gap-2">
              <button type="submit" className={`btn ${pilihan === "tambah" ? "btn-primary" : "btn-warning"}`}>
                {pilihan === "tambah" ? "Tambah" : "Update"}
              </button>
              {pilihan === "ubah" && (
                <button
                  type="button"
                  className="btn btn-secondary"
                  onClick={() => {
                    setPilihan("tambah");
                    setIdkategori("");
                    reset();
                  }}
                >
                  Batal
                </button>
              )}
            </div>
          </form>
        </div>
      </div>

      {/* Tabel data kategori */}
      <div className="card shadow-sm">
        <div className="card-header bg-secondary text-white">
          Tabel Kategori
        </div>
        <div className="card-body p-0">
          <div className="table-responsive">
            <table className="table table-striped table-hover mb-0">
              <thead className="table-dark">
                <tr>
                  <th scope="col" style={{width: "5%"}}>No</th>
                  <th scope="col">Nama Kategori</th>
                  <th scope="col">Keterangan</th>
                  <th scope="col" style={{width: "18%"}}>Aksi</th>
                </tr>
              </thead>
              <tbody>
                {isi.length === 0 ? (
                  <tr>
                    <td colSpan="4" className="text-center text-muted">Belum ada data</td>
                  </tr>
                ) : (
                  isi.map((item, index) => (
                    <tr key={item.idkategori}>
                      <td>{index + 1}</td>
                      <td>{item.kategori}</td>
                      <td>{item.keterangan}</td>
                      <td>
                        <div className="btn-group" role="group">
                          <button
                            onClick={() => editData(item)}
                            className="btn btn-warning btn-sm"
                          >
                            <i className="bi bi-pencil-square"></i> Ubah
                          </button>
                          <button
                            onClick={() => hapus(item.idkategori)}
                            className="btn btn-danger btn-sm"
                          >
                            <i className="bi bi-trash"></i> Hapus
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Kategori;