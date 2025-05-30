import React, { useState } from "react";
import useGet from "../hook/useGet";
import useDelete from "../hook/useDelete";
import axios from "../axios/link";
import { Modal, Button } from "react-bootstrap";

const Order = () => {
  // Ambil data order dari API
  const { isi: orders = [], setIsi: setOrders } = useGet("/order");
  const { pesan, hapus } = useDelete();

  // State untuk filter, modal, pelunasan, dan pagination
  const [currentPage, setCurrentPage] = useState(1);
  const [startDate, setStartDate] = useState("");
  const [endDate, setEndDate] = useState("");
  const [filteredOrders, setFilteredOrders] = useState([]);
  const [showModal, setShowModal] = useState(false);
  const [selectedOrder, setSelectedOrder] = useState(null);
  const [bayar, setBayar] = useState("");
  const itemsPerPage = 5;

  // Filter data order berdasarkan tanggal
  const handleSearch = () => {
    const filtered = orders.filter((order) => {
      const orderDate = new Date(order.tglorder);
      const start = startDate ? new Date(startDate) : null;
      const end = endDate ? new Date(endDate) : null;

      if (start && orderDate < start) return false;
      if (end && orderDate > end) return false;

      return true;
    });
    setFilteredOrders(filtered);
    setCurrentPage(1);
  };

  // Reset filter tanggal
  const handleReset = () => {
    setStartDate("");
    setEndDate("");
    setFilteredOrders([]);
    setCurrentPage(1);
  };

  // Tentukan data yang akan ditampilkan (filtered atau semua)
  const dataToDisplay =
    filteredOrders.length > 0 || (startDate || endDate)
      ? filteredOrders
      : orders;

  // Pagination logic
  const indexOfLastItem = currentPage * itemsPerPage;
  const indexOfFirstItem = indexOfLastItem - itemsPerPage;
  const currentItems = dataToDisplay.slice(indexOfFirstItem, indexOfLastItem);
  const totalPages = Math.ceil(dataToDisplay.length / itemsPerPage);

  const handlePageChange = (pageNumber) => {
    setCurrentPage(pageNumber);
  };

  // Hapus order
  const handleDelete = (idorder) => {
    hapus("/order", idorder, setOrders);
  };

  // Buka modal pelunasan
  const openPelunasanModal = (order) => {
    setSelectedOrder(order);
    setBayar(order.total - order.bayar); // default isi kekurangan
    setShowModal(true);
  };

  // Tutup modal pelunasan
  const handleCloseModal = () => {
    setShowModal(false);
    setSelectedOrder(null);
    setBayar("");
  };

  // Simpan pelunasan
  const handleSimpanPelunasan = async () => {
    if (!selectedOrder) return;

    const newBayar = parseInt(bayar);
    const updatedOrder = {
      bayar: selectedOrder.bayar + newBayar,
      kembali: selectedOrder.bayar + newBayar - selectedOrder.total,
      status: selectedOrder.bayar + newBayar >= selectedOrder.total ? 1 : 0,
    };

    try {
      await axios.put(`/order/${selectedOrder.idorder}`, updatedOrder);
      const res = await axios.get("/order");
      setOrders(res.data);
      handleCloseModal();
    } catch (err) {
      console.error("Gagal update order:", err);
    }
  };

  return (
    <div className="container py-3">
      {/* Judul halaman */}
      <div className="row mb-3">
        <div className="col">
          <h3 className="fw-bold text-primary">Daftar Order</h3>
        </div>
      </div>

      {/* Filter Tanggal */}
      <div className="card shadow-sm mb-4">
        <div className="card-body">
          <div className="row g-3 align-items-end">
            <div className="col-md-3">
              <label className="form-label">Tanggal Awal</label>
              <input
                type="date"
                className="form-control"
                value={startDate}
                onChange={(e) => setStartDate(e.target.value)}
              />
            </div>
            <div className="col-md-3">
              <label className="form-label">Tanggal Akhir</label>
              <input
                type="date"
                className="form-control"
                value={endDate}
                onChange={(e) => setEndDate(e.target.value)}
              />
            </div>
            <div className="col-md-3 d-flex gap-2">
              <button className="btn btn-primary" onClick={handleSearch}>
                Cari
              </button>
              <button className="btn btn-secondary" onClick={handleReset}>
                Reset
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* Pesan sukses/gagal */}
      {pesan && <div className="alert alert-success">{pesan}</div>}

      {/* Tabel daftar order */}
      <div className="card shadow-sm">
        <div className="card-header bg-secondary text-white">
          Tabel Order
        </div>
        <div className="card-body p-0">
          <div className="table-responsive">
            <table className="table table-bordered table-striped mb-0 align-middle">
              <thead className="table-dark">
                <tr>
                  <th>No</th>
                  <th>Faktur</th>
                  <th>Pelanggan</th>
                  <th>Tanggal Order</th>
                  <th>Total</th>
                  <th>Bayar</th>
                  <th>Kembali</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                {currentItems.length > 0 ? (
                  currentItems.map((item, index) => (
                    <tr key={item.idorder}>
                      <td>{indexOfFirstItem + index + 1}</td>
                      <td>{item.idorder}</td>
                      <td>{item.pelanggan}</td>
                      <td>{new Date(item.tglorder).toLocaleDateString()}</td>
                      <td>Rp {item.total?.toLocaleString()}</td>
                      <td>Rp {item.bayar?.toLocaleString()}</td>
                      <td>Rp {item.kembali?.toLocaleString()}</td>
                      <td>
                        <span
                          className={`badge ${item.status === 1 ? "bg-success" : "bg-warning"}`}
                          style={{ cursor: item.status !== 1 ? "pointer" : "default" }}
                          onClick={() => item.status !== 1 && openPelunasanModal(item)}
                        >
                          {item.status === 1 ? "Lunas" : "Belum Lunas"}
                        </span>
                      </td>
                      <td>
                        <button
                          onClick={() => handleDelete(item.idorder)}
                          className="btn btn-danger btn-sm"
                        >
                          <i className="bi bi-trash"></i> Hapus
                        </button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="9" className="text-center text-muted">
                      {orders.length === 0 ? "Memuat data..." : "Tidak ada data ditemukan"}
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {/* Pagination Bootstrap */}
      {dataToDisplay.length > 0 && (
        <nav className="mt-3">
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

      {/* Modal Pelunasan */}
      <Modal show={showModal} onHide={handleCloseModal} centered>
        <Modal.Header closeButton>
          <Modal.Title>Form Pelunasan</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          {selectedOrder && (
            <>
              <p><strong>Pelanggan:</strong> {selectedOrder.pelanggan}</p>
              <p><strong>Total:</strong> Rp {selectedOrder.total?.toLocaleString()}</p>
              <div className="mb-3">
                <label htmlFor="bayar" className="form-label">Bayar</label>
                <input
                  type="number"
                  id="bayar"
                  className="form-control"
                  value={bayar}
                  onChange={(e) => setBayar(e.target.value)}
                />
              </div>
            </>
          )}
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={handleCloseModal}>
            Batal
          </Button>
          <Button variant="primary" onClick={handleSimpanPelunasan}>
            Simpan Pelunasan
          </Button>
        </Modal.Footer>
      </Modal>
    </div>
  );
};

export default Order;