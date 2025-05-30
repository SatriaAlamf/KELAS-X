import React, { useState, useEffect } from "react";
import useGet from "../hook/useGet";
import useDelete from "../hook/useDelete";

const Detail = () => {
  const today = new Date();
  const defaultTglAkhir = today.toISOString().split("T")[0];
  const defaultTglAwal = new Date(today.getTime() - (7 * 24 * 60 * 60 * 1000)).toISOString().split("T")[0];

  const [tglAwal, setTglAwal] = useState(defaultTglAwal);
  const [tglAkhir, setTglAkhir] = useState(defaultTglAkhir);
  const [fetchUrl, setFetchUrl] = useState(`/detail/${defaultTglAwal}/${defaultTglAkhir}`);

  const { isi: response, setIsi: setResponse, loading, error } = useGet(fetchUrl);
  const { pesan, hapus } = useDelete();
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 5;

  // Tangani perubahan tanggal dan pencarian
  const handleSearch = () => {
    setFetchUrl(`/detail/${tglAwal}/${tglAkhir}`);
    setCurrentPage(1);
  };

  const handleReset = () => {
    setTglAwal(defaultTglAwal);
    setTglAkhir(defaultTglAkhir);
    setFetchUrl(`/detail/${defaultTglAwal}/${defaultTglAkhir}`);
    setCurrentPage(1);
  };

  // Ekstrak array dari response API
  let details = [];
  if (Array.isArray(response)) {
    details = response;
  } else if (response && typeof response === "object") {
    if (Array.isArray(response.details)) {
      details = response.details;
    } else if (Array.isArray(response.data)) {
      details = response.data;
    } else {
      const keys = Object.keys(response);
      const arrayKey = keys.find((k) => Array.isArray(response[k]));
      if (arrayKey) details = response[arrayKey];
    }
  }

  // Pagination
  const indexOfLastItem = currentPage * itemsPerPage;
  const indexOfFirstItem = indexOfLastItem - itemsPerPage;
  const currentItems = details.slice(indexOfFirstItem, indexOfLastItem);
  const totalPages = Math.ceil(details.length / itemsPerPage);

  const handlePageChange = (pageNumber) => setCurrentPage(pageNumber);

  const handleDelete = (iddetail) => {
    hapus("/detail", iddetail, (updatedData) => {
      setResponse(updatedData);
    });
  };

  return (
    <div className="container py-4">
      <div className="card shadow-sm mb-4">
        <div className="card-header bg-primary text-white">
          <h4 className="mb-0">Detail Order</h4>
        </div>
        <div className="card-body">
          <form className="row g-3 align-items-end mb-3" onSubmit={e => { e.preventDefault(); handleSearch(); }}>
            <div className="col-md-3">
              <label className="form-label">Tanggal Awal</label>
              <input
                type="date"
                className="form-control"
                value={tglAwal}
                onChange={(e) => setTglAwal(e.target.value)}
              />
            </div>
            <div className="col-md-3">
              <label className="form-label">Tanggal Akhir</label>
              <input
                type="date"
                className="form-control"
                value={tglAkhir}
                onChange={(e) => setTglAkhir(e.target.value)}
              />
            </div>
            <div className="col-md-3 d-flex gap-2">
              <button type="submit" className="btn btn-primary">
                Cari
              </button>
              <button type="button" onClick={handleReset} className="btn btn-secondary">
                Reset
              </button>
            </div>
          </form>

          {pesan && (
            <div className="alert alert-success mt-3">
              {pesan}
            </div>
          )}

          <div className="table-responsive">
            <table className="table table-bordered table-striped align-middle">
              <thead className="table-dark">
                <tr>
                  <th>No</th>
                  <th>Faktur</th>
                  <th>Tanggal Order</th>
                  <th>Menu</th>
                  <th>Harga Jual</th>
                  <th>Jumlah</th>
                  <th>Total</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                {loading ? (
                  <tr>
                    <td colSpan="8" className="text-center">
                      <div className="spinner-border" role="status">
                        <span className="visually-hidden">Loading...</span>
                      </div>
                      <span className="ms-2">Memuat data...</span>
                    </td>
                  </tr>
                ) : error ? (
                  <tr>
                    <td colSpan="8" className="text-center text-danger">
                      Error: {error}
                    </td>
                  </tr>
                ) : currentItems && currentItems.length > 0 ? (
                  currentItems.map((item, index) => (
                    <tr key={item.iddetail || index}>
                      <td>{indexOfFirstItem + index + 1}</td>
                      <td>{item.idorder}</td>
                      <td>{item.tglorder ? new Date(item.tglorder).toLocaleDateString() : "-"}</td>
                      <td>{item.menu}</td>
                      <td>Rp {item.hargajual?.toLocaleString() || "0"}</td>
                      <td>{item.jumlah || 0}</td>
                      <td>Rp {((item.hargajual || 0) * (item.jumlah || 0)).toLocaleString()}</td>
                      <td>
                        <button
                          onClick={() => handleDelete(item.iddetail)}
                          className="btn btn-danger btn-sm"
                        >
                          <i className="bi bi-trash"></i> Hapus
                        </button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="8" className="text-center">
                      Tidak ada data
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>

          {details.length > 0 && (
            <nav className="mt-3" aria-label="Page navigation">
              <ul className="pagination justify-content-center">
                <li className={`page-item ${currentPage === 1 ? "disabled" : ""}`}>
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
                    key={index}
                    className={`page-item ${currentPage === index + 1 ? "active" : ""}`}
                  >
                    <button
                      className="page-link"
                      onClick={() => handlePageChange(index + 1)}
                    >
                      {index + 1}
                    </button>
                  </li>
                ))}
                <li className={`page-item ${currentPage === totalPages ? "disabled" : ""}`}>
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
      </div>
    </div>
  );
};

export default Detail;