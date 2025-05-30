import React from 'react';

const Nav = () => {
  const email = localStorage.getItem('email'); // Ambil email dari localStorage

  // Fungsi logout: hapus data user dari localStorage dan redirect ke login
  const handleLogout = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('level');
    localStorage.removeItem('email');
    window.location.href = '/login';
  };

  return (
    // Navbar Bootstrap dengan desain modern dan pesan selamat datang
    <nav className="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3 py-2 mb-3 border-bottom">
      <div className="container-fluid d-flex justify-content-between align-items-center">
        {/* Judul dashboard */}
        <span className="navbar-brand mb-0 h1 text-primary fw-bold d-flex align-items-center">
          <i className="bi bi-house-door-fill me-2"></i>
          Dashboard Admin
        </span>
        {/* Info user dan tombol logout */}
        <div className="d-flex align-items-center gap-3">
          {email && (
            <span className="text-dark small">
              <i className="bi bi-person-circle me-1"></i>
              <strong>{email}</strong>
            </span>
          )}
          <button className="btn btn-outline-danger btn-sm fw-bold" onClick={handleLogout}>
            <i className="bi bi-box-arrow-right me-1"></i>
            Logout
          </button>
        </div>
      </div>
    </nav>
  );
};

export default Nav;