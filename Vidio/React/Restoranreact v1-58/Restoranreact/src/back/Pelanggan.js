import React from "react";
import useGet from "../hook/useGet";
import useDelete from "../hook/useDelete";

const Pelanggan = () => {
  // Ambil data pelanggan dari API
  const { isi, setIsi } = useGet("/pelanggan");
  const { pesan, hapus } = useDelete();

  // Debug log data pelanggan
  console.log('Data pelanggan:', isi);

  return (
    <div className="container py-3">
      {/* Judul halaman */}
      <div className="row mb-3">
        <div className="col">
          <h3 className="fw-bold text-primary">Daftar Pelanggan</h3>
        </div>
      </div>

      {/* Pesan sukses/gagal */}
      {pesan && (
        <div className="alert alert-success alert-dismissible fade show" role="alert">
          {pesan}
          <button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      )}

      {/* Tabel daftar pelanggan */}
      <div className="card shadow-sm">
        <div className="card-header bg-secondary text-white">
          Tabel Pelanggan
        </div>
        <div className="card-body p-0">
          <div className="table-responsive">
            <table className="table table-bordered table-striped mb-0 align-middle">
              <thead className="table-dark">
                <tr>
                  <th>No</th>
                  <th>Pelanggan</th>
                  <th>Alamat</th>
                  <th>Telp</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                {isi.length > 0 ? (
                  isi.map((data, index) => (
                    <tr key={data.idpelanggan || index}>
                      <td className="text-center">{index + 1}</td>
                      <td>{data.pelanggan}</td>
                      <td>{data.alamat}</td>
                      <td>{data.telp}</td>
                      <td className="text-center">
                        <button
                          onClick={() => hapus("/pelanggan", data.idpelanggan, setIsi)}
                          className="btn btn-danger btn-sm"
                        >
                          <i className="bi bi-trash"></i> Hapus
                        </button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="5" className="text-center py-4 text-muted">
                      Tidak ada data pelanggan.
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Pelanggan;