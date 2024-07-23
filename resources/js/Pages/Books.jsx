import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import BookList from '../Components/Book/BookList';
import { route } from 'ziggy-js';
import { useEffect } from 'react';
import Pagination from '../Components/Pagination';

export default function Book({ auth, books, search, perPage, translations }) {
  const { data, setData, get, processing } = useForm({
    search: search || '',
    per_page: perPage || 10,
  });

  const handleSearch = (e) => {
    e.preventDefault();
    get(
      route('books.index', { search: data.search, per_page: data.per_page }),
      { preserveState: true }
    );
  };

  const handlePerPageChange = (value) => {
    setData('per_page', value);
    get(route('books.index', { search: data.search, per_page: value }), {
      preserveState: true,
    });
  };

  useEffect(() => {
    const debounce = setTimeout(() => {
      if (data.search !== search) {
        get(
          route('books.index', {
            search: data.search,
            per_page: data.per_page,
          }),
          {
            preserveState: true,
          }
        );
      }
    }, 300);
    return () => clearTimeout(debounce);
  }, [data.search, data.per_page]);

  const PerPageOption = ({ value }) => (
    <button
      onClick={() => handlePerPageChange(value)}
      className={`px-2   ${
        data.per_page === value
          ? ' text-gray-950 font-semibold'
          : ' text-gray-500'
      }`}
    >
      {value}
    </button>
  );

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
          {translations.title}
        </h2>
      }
    >
      <Head title="Books" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">
              <form onSubmit={handleSearch} className="mb-4">
                <input
                  type="text"
                  value={data.search}
                  onChange={(e) => setData('search', e.target.value)}
                  placeholder={translations.search}
                  className="w-full px-4 py-2 border rounded-md"
                />
              </form>
              <div className="flex items-center justify-end ml-4 mb-2 text-sm">
                <PerPageOption value={10} />
                <span className="text-gray-500">|</span>
                <PerPageOption value={20} />
                <span className="text-gray-500">|</span>
                <PerPageOption value={50} />
              </div>

              <BookList books={books.data} translations={translations} />
              <Pagination links={books.links} />
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
