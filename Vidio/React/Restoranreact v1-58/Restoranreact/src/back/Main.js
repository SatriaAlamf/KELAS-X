import { Route, Routes } from 'react-router-dom';
import Kategori from './Kategori';
import content from './Content';
import Menu from './Menu';
import Pelanggan from './Pelanggan';
import Order from './Order';
import Detail from './Detail';
import User from './User';

const Main = () => {
    return (
        <div className="main-content">
            {/* Pesan selamat datang dan info admin dashboard */}
            <div className="alert alert-primary d-flex align-items-center mb-4" role="alert">
                <i className="bi bi-speedometer2 me-2 fs-4"></i>
                <div>
                    Selamat datang di <strong>Admin Dashboard</strong> Alam's Resto! Silakan pilih menu di samping untuk mengelola data.
                </div>
            </div>
            {/* Routing utama untuk setiap halaman admin */}
            <div className="card shadow-sm border-0">
                <div className="card-body">
                    <Routes>
                        {/* Route untuk halaman admin default */}
                        <Route path="/" element={
                            <div className="text-center py-5">
                                <h2 className="fw-bold mb-3">Dashboard Admin</h2>
                                <p className="lead text-muted">
                                    Kelola data kategori, menu, pelanggan, order, dan lainnya melalui menu navigasi di samping.
                                </p>
                                <i className="bi bi-gear display-4 text-secondary"></i>
                            </div>
                        } />
                        {/* Route kategori */}
                        <Route path="kategori" element={<Kategori />} />
                        {/* Route menu */}
                        <Route path="menu" element={<Menu />} />
                        {/* Route pelanggan */}
                        <Route path="pelanggan" element={<Pelanggan />} />
                        {/* Route order */}
                        <Route path="order" element={<Order />} />
                        {/* Route detail */}
                        <Route path="detail" element={<Detail />} />
                        {/* Route admin/user */}
                        <Route path="admin" element={<User />} />
                        {/* Routes lain dengan parameter */}
                        <Route path="menu/:idmenu" element={<content.MENU />} />
                        <Route path="pelanggan/:idpelanggan" element={<content.PELANGGAN />} />
                        <Route path="order/:idorder" element={<content.ORDER />} />
                        <Route path="detail/:iddetail" element={<content.DETAIL />} />
                        <Route path="admin/:idadmin" element={<content.ADMIN />} />
                    </Routes>
                </div>
            </div>
        </div>
    );
};

export default Main;