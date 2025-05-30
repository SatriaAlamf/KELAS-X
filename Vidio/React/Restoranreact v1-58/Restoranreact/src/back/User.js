import React, { useState } from "react";
import axios from "../axios/link";
import useGet from "../hook/useGet";
import useDelete from "../hook/useDelete";
import { useForm } from "react-hook-form";

const Menu = () => {
  // Ambil data menu dan kategori dari API
  const { isi: menus = [], setIsi: setMenus } = useGet("/menu");
  const { isi: kategoris = [] } = useGet("/kategori");
  const { pesan: pesanHapus, hapus } = useDelete();

  // State untuk pesan, edit, gambar, dan pagination
  const [pesan, setPesan] = useState("");
  const [editId, setEditId] = useState(null);
  const [currentImage, setCurrentImage] = useState(null);
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 5;

  // Pagination logic
  const indexOfLastItem = currentPage * itemsPerPage;
  const indexOfFirstItem = indexOfLastItem - itemsPerPage;
  const currentItems = menus.slice(indexOfFirstItem, indexOfLastItem);
  const totalPages = Math.ceil(menus.length / itemsPerPage);

  const handlePageChange = (pageNumber) => setCurrentPage(pageNumber);

  // React Hook Form setup
  const {
    register,
    handleSubmit,
    reset,
    setValue,
    formState: { errors },
  } = useForm();

  // Fungsi untuk mengisi form dengan data yang akan diedit
  const handleEdit = (menu) => {
    setEditId(menu.idmenu);
    setValue("menu", menu.menu);
    setValue("idkategori", menu.idkategori);
    setValue("harga", menu.harga);
    setCurrentImage(menu.gambar);
  };

  // Fungsi submit tambah/ubah menu
  const onSubmit = async (data) => {
    try {
      const formData = new FormData();
      formData.append("idkategori", data.idkategori);
      formData.append("menu", data.menu);
      formData.append("harga", data.harga);
      if (data.gambar && data.gambar[0]) {
        formData.append("gambar", data.gambar[0]);
      }

      let response;
      if (editId) {
        // Update menu
        formData.append("idmenu", editId);
        response = await axios.post(`/menu/${editId}`, formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });
      } else {
        // Tambah menu baru
        response = await axios.post("/menu", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });
      }

      if (response.data) {
        // Refresh data menu setelah tambah/ubah
        const refreshResponse = await axios.get("/menu");
        setMenus(refreshResponse.data);
        setPesan(editId ? "Menu berhasil diubah" : "Menu berhasil ditambahkan");
        reset();
        setEditId(null);
        setCurrentImage(null);
        setCurrentPage(1);
        setTimeout(() => setPesan(""), 3000);
      }
    } catch (error) {
      console.error("Gagal:", error);
      setPesan(error.response?.data?.pesan || `Gagal ${editId ? 'mengubah' : 'menambahkan'} menu!`);
      setTimeout(() => setPesan(""), 3000);
    }
  };

  // Fungsi hapus menu
  const handleDelete = (idmenu) => {
    hapus("/menu", idmenu, setMenus);
  };

  return (
    <div className="container py-3">
      {/* Judul halaman */}
      <div className="row mb-3">
        <div className="col">
          <h3 className="fw-bold text-primary">Daftar Menu</h3>
        </div>
      </div>

      {/* Pesan sukses/gagal */}
      {(pesan || pesanHapus) && (
        <div className="alert alert-success alert-dismissible fade show" role="alert">
          {pesan || pesanHapus}
          <button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"
            onClick={() => setPesan("")}></button>
        </div>
      )}

      {/* Form tambah/ubah menu */}
      <div className="card shadow-sm mb-4">
        <div className="card-header bg-primary text-white">
          {editId ? "Ubah Menu" : "Tambah Menu"}
        </div>
        <div className="card-body">
          <form onSubmit={handleSubmit(onSubmit)} className="row g-3">
            <div className="col-md-6">
              <label htmlFor="menu" className="form-label">Nama Menu</label>
              <input
                type="text"
                className={`form-control ${errors.menu ? 'is-invalid' : ''}`}
                {...register("menu", { required: "Nama menu harus diisi" })}
                placeholder="Masukkan nama menu"
              />
              {errors.menu && <div className="invalid-feedback">{errors.menu.message}</div>}
            </div>
            <div className="col-md-6">
              <label htmlFor="kategori" className="form-label">Kategori</label>
              <select
                className={`form-select ${errors.idkategori ? 'is-invalid' : ''}`}
                {...register("idkategori", { required: "Kategori harus dipilih" })}
              >
                <option value="">Pilih Kategori</option>
                {kategoris.map(kategori => (
                  <option key={kategori.idkategori} value={kategori.idkategori}>
                    {kategori.kategori}
                  </option>
                ))}
              </select>
              {errors.idkategori && <div className="invalid-feedback">{errors.idkategori.message}</div>}
            </div>
            <div className="col-md-6">
              <label htmlFor="harga" className="form-label">Harga</label>
              <input
                type="number"
                className={`form-control ${errors.harga ? 'is-invalid' : ''}`}
                {...register("harga", { required: "Harga harus diisi", min: { value: 0, message: "Harga tidak boleh negatif" } })}
                placeholder="Masukkan harga"
              />
              {errors.harga && <div className="invalid-feedback">{errors.harga.message}</div>}
            </div>
            <div className="col-md-6">
              <label htmlFor="gambar" className="form-label">Gambar Menu</label>
              {currentImage && editId && (
                <div className="mb-2">
                  <img
                    src={currentImage}
                    alt="Current Menu"
                    style={{ width: "100px", height: "100px", objectFit: "cover" }}
                    className="rounded border"
                  />
                  <p className="small text-muted mb-0">Gambar saat ini (opsional untuk ganti)</p>
                </div>
              )}
              <input
                type="file"
                className={`form-control ${errors.gambar ? 'is-invalid' : ''}`}
                accept="image/*"
                {...register("gambar", { required: !editId })}
              />
              {errors.gambar && <div className="invalid-feedback">Gambar harus dipilih</div>}
            </div>
            <div className="col-12 d-flex gap-2">
              <button type="submit" className={`btn ${editId ? "btn-warning" : "btn-primary"}`}>
                {editId ? "Update Menu" : "Tambah Menu"}
              </button>
              {editId && (
                <button
                  type="button"
                  className="btn btn-secondary"
                  onClick={() => {
                    reset();
                    setEditId(null);
                    setCurrentImage(null);
                  }}
                >
                  Batal
                </button>
              )}
            </div>
          </form>
        </div>
      </div>

      {/* Tabel daftar menu */}
      <div className="card shadow-sm">
        <div className="card-header bg-secondary text-white">
          Tabel Menu
        </div>
        <div className="card-body p-0">
          <div className="table-responsive">
            <table className="table table-bordered table-striped mb-0 align-middle">
              <thead className="table-dark">
                <tr>
                  <th>No</th>
                  <th>Menu</th>
                  <th>Kategori</th>
                  <th>Harga</th>
                  <th>Gambar</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                {currentItems && currentItems.length > 0 ? (
                  currentItems.map((item, index) => (
                    <tr key={item.idmenu}>
                      <td>{indexOfFirstItem + index + 1}</td>
                      <td>{item.menu}</td>
                      <td>{item.kategori}</td>
                      <td>Rp {item.harga?.toLocaleString()}</td>
                      <td>
                        <img
                          src={item.gambar}
                          alt={item.menu}
                          style={{ width: "80px", height: "80px", objectFit: "cover" }}
                          className="rounded border"
                        />
                      </td>
                      <td className="text-center">
                        <button
                          onClick={() => handleEdit(item)}
                          className="btn btn-warning btn-sm me-2"
                        >
                          <i className="bi bi-pencil-square"></i> Ubah
                        </button>
                        <button
                          onClick={() => handleDelete(item.idmenu)}
                          className="btn btn-danger btn-sm"
                        >
                          <i className="bi bi-trash"></i> Hapus
                        </button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="6" className="text-center text-muted">
                      {menus.length === 0 ? "Tidak ada data" : "Memuat data..."}
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {/* Pagination Bootstrap */}
      {menus.length > 0 && (
        <nav aria-label="Page navigation" className="mt-3">
          <ul className="pagination justify-content-center">
            <li className={`page-item ${currentPage === 1 ? 'disabled' : ''}`}>
              <button
                className="page-link"
                onClick={() => handlePageChange(currentPage - 1)}
                disabled={currentPage === 1}
              >
                Previous
              </button>
            </li>
            {[...Array(totalPages)].map((_, index) => (
              <li
                key={index + 1}
                className={`page-item ${currentPage === index + 1 ? 'active' : ''}`}
              >
                <button
                  className="page-link"
                  onClick={() => handlePageChange(index + 1)}
                >
                  {index + 1}
                </button>
              </li>
            ))}
            <li className={`page-item ${currentPage === totalPages ? 'disabled' : ''}`}>
              <button
                className="page-link"
                onClick={() => handlePageChange(currentPage + 1)}
                disabled={currentPage === totalPages}
              >
                Next
              </button>
            </li>
          </ul>
        </nav>
      )}
    </div>
  );
};

export default Menu;