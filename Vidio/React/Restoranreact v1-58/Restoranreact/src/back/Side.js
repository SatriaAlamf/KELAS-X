import { Link } from 'react-router-dom';

const URL = {
    kategori: "/admin/kategori",
    menu: "/admin/menu",
    pelanggan: "/admin/pelanggan",
    order: "/admin/order",
    orderDetail: "/admin/detail",
    admin: "/admin/admin"
};

const Side = () => {
    const userLevel = localStorage.getItem('level');
    return (
        <aside className="side">
            {/* Sidebar Bootstrap dengan list-group */}
            <div className="card shadow-sm mb-3">
                <div className="card-header bg-primary text-white">
                    <h5 className="mb-0"><i className="bi bi-list me-2"></i>Menu Aplikasi</h5>
                </div>
                <ul className="list-group list-group-flush">
                    {/* Pesan akses sesuai level user */}
                    <li className="list-group-item bg-light text-secondary small">
                        {userLevel === 'admin' && "Anda login sebagai Admin. Semua menu tersedia."}
                        {userLevel === 'kasir' && "Anda login sebagai Kasir. Menu kasir tersedia."}
                        {userLevel === 'koki' && "Anda login sebagai Koki. Hanya menu dapur tersedia."}
                    </li>

                    {/* Admin & Kasir: akses order & order detail */}
                    {(userLevel === 'admin' || userLevel === 'kasir') && (
                        <>
                            <li>
                                <Link to={URL.order} className="list-group-item list-group-item-action" title="Order">
                                    <i className="bi bi-cart-check me-2"></i>Order
                                </Link>
                            </li>
                            <li>
                                <Link to={URL.orderDetail} className="list-group-item list-group-item-action" title="Order Detail">
                                    <i className="bi bi-receipt-cutoff me-2"></i>Order Detail
                                </Link>
                            </li>
                        </>
                    )}

                    {/* Koki: hanya order detail */}
                    {userLevel === 'koki' && (
                        <li>
                            <Link to={URL.orderDetail} className="list-group-item list-group-item-action" title="Order Detail">
                                <i className="bi bi-receipt-cutoff me-2"></i>Order Detail
                            </Link>
                        </li>
                    )}

                    {/* Admin: akses semua menu */}
                    {userLevel === 'admin' && (
                        <>
                            <li>
                                <Link to={URL.kategori} className="list-group-item list-group-item-action" title="Kategori">
                                    <i className="bi bi-tags me-2"></i>Kategori
                                </Link>
                            </li>
                            <li>
                                <Link to={URL.menu} className="list-group-item list-group-item-action" title="Menu">
                                    <i className="bi bi-cup-straw me-2"></i>Menu
                                </Link>
                            </li>
                            <li>
                                <Link to={URL.pelanggan} className="list-group-item list-group-item-action" title="Pelanggan">
                                    <i className="bi bi-people me-2"></i>Pelanggan
                                </Link>
                            </li>
                            <li>
                                <Link to={URL.admin} className="list-group-item list-group-item-action" title="Admin">
                                    <i className="bi bi-person-gear me-2"></i>User Admin
                                </Link>
                            </li>
                        </>
                    )}
                </ul>
            </div>
        </aside>
    );
};

export default Side;